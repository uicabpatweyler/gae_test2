<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Models\SalidaProducto;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VentasPorDia extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\ReporteDiarioVenta $pdf)
  {
    $this->pdf = $pdf;
  }
  /*
   * 45 filas por pagina
   * 1er pagina: espacio (1), resumen (3), espacio (1), encabezado tabla(1)
   * Total primera pagina: 38
   * Resto paginas: Titulo, espacio (1), encabezado tabla(3)
   * Total otras paginas: 45 - 4 = 41
   *
   */
  public function printPDF(){

    $fechaReporte = '2018-08-16';
    $numLibros = 0;
    $numPlayeras = 0;
    $importeLibros = 0;
    $importePlayeras = 0;
    $numeroRecibos = 0;
    $recibosCancelados = 0;

    $salidas = DB::table('salida_productos')
      ->join('alumnos', 'salida_productos.alumno_id', '=', 'alumnos.id')
      ->select('salida_productos.*')
      ->addselect('alumnos.id as alumno_id','alumnos.nombre1', 'alumnos.nombre2', 'alumnos.apellido1', 'alumnos.apellido2')
      ->whereDate('fecha_venta', $fechaReporte)
      ->orderBy('folio_recibo', 'asc')
      ->get();

    $rows = [];
    $numLinea = 1;
    foreach ($salidas as $salida) {

      $numeroRecibos++;

      if($salida->venta_cancelada){
        $recibosCancelados++;
      }

      $detalles = DB::table('detalle_salida_productos')
        ->join('productos','detalle_salida_productos.producto_id', '=', 'productos.id')
        ->select('detalle_salida_productos.*')
        ->addSelect('productos.nombre_categoria', 'productos.nombre as nombre_producto')
        ->where('salidaprod_id','=', $salida->id)
        ->orderBy('numero_linea','asc')
        ->get();

      foreach ($detalles as $detalle) {
        if($detalle->nombre_categoria === 'Libro'){
          $numLibros = $numLibros + $detalle->cantidad;
          $importeLibros = $importeLibros + ($detalle->precio_unitario * $detalle->cantidad);
        }
        if($detalle->nombre_categoria === 'Playera'){
          $numPlayeras = $numPlayeras + $detalle->cantidad;
          $importePlayeras = $importePlayeras + ($detalle->precio_unitario * $detalle->cantidad);
        }
        $rows[]= [
          'numLinea'  => $numLinea,
          'recibo'    => $salida-> serie_recibo.'-'.$salida->folio_recibo,
          'cancelado' => $salida->venta_cancelada ? 'Si' : '',
          'nombre1'    => $salida->nombre1,
          'nombre2'    => strlen($salida->nombre2)!==0 ?  ' '.substr($salida->nombre2,0,1).'.' : '',
          'apellido1'  => $salida->apellido1,
          'apellido2'  => strlen($salida->apellido1)!==0 ?  ' '.substr($salida->apellido2,0,1).'.' : '',
          'producto'   => $detalle->nombre_producto,
          'fecha_cancelacion' => $salida->fecha_cancelacion!==null ? $salida->fecha_cancelacion->format('Y-m-d') : '',
          'cantidad'   => $detalle->cantidad,
          'precio_unitario' => $detalle->precio_unitario,
          'importe' => $detalle->precio_unitario * $detalle->cantidad
        ];
      }
      $numLinea++;
    }

    //$salida->nombre1.strlen($salida->nombre2)!==0 ?  ' '.substr($salida->nombre2,0,1).'.' : ''

    //return $rows;

    $data = $this->detailsRowsReport(count($rows));

    $this->pdf->SetMargins(5,5,5);
    $this->pdf->SetAutoPageBreak(true,20);
    $this->pdf->AliasNbPages();

    for($pagina = 0; $pagina < count($data); $pagina++){
      $this->pdf->AddPage('P','Letter');
      $this->tituloPaginacion();
      $this->espacio(5);
      if($data[$pagina]['page'] === 1){
        $this->resumen($numLibros, $numPlayeras, $importeLibros, $importePlayeras, $numeroRecibos, $recibosCancelados);
        $this->espacio(5);
      }
      $this->encabezadoTabla();

      $_begin = $data[$pagina]['rowBegin'];
      $_end   = $data[$pagina]['rowEnd'];

      $this->pdf->SetFillColor(230,242,230);
      $this->pdf->SetFont('Arial', '', 7);

      for($_x = $_begin-1; $_x < $_end; $_x++){
        $fill = $_x % 2 ? true : false;
        $this->pdf->Cell(8,5,$rows[$_x]['numLinea'],0,0,'C',$fill);
        $this->pdf->Cell(14,5,$rows[$_x]['recibo'],0,0,'C',$fill);
        $this->pdf->Cell(12,5,$rows[$_x]['cancelado'],0,0,'C',$fill);
        $this->pdf->Cell(35,5,utf8_decode($rows[$_x]['nombre1'].' '.$rows[$_x]['nombre2'].' '.$rows[$_x]['apellido1'].' '.$rows[$_x]['apellido2']),0,0,'L',$fill);
        $this->pdf->Cell(75,5,utf8_decode($rows[$_x]['producto']),0,0,'L',$fill);
        $this->pdf->Cell(20,5,$rows[$_x]['fecha_cancelacion'],0,0,'C',$fill);
        $this->pdf->Cell(10,5,$rows[$_x]['cantidad'],0,0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($rows[$_x]['precio_unitario'],2,'.',','),0,0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($rows[$_x]['importe'],2,'.',','),0,1,'C',$fill);
      }
    }
    $this->pdf->Output();
    exit;
  }

  public function detailsRowsReport($totalRows){
    $aux = [];
    $allRows        = $totalRows;
    $rowsFirstPage  = 38;
    $rowsOthersPage = 42;
    $rowBegin      = 1;
    $rowEnd         = $rowsFirstPage;
    $page           = 1;

    if($allRows <= $rowsFirstPage){
      $aux[] = [
        'page'     => $page,
        'rowBegin' => $rowBegin,
        'rowEnd'   => $allRows
      ];
    }
    else{
      $aux[] = [
        'page'     => $page++,
        'rowBegin' => $rowBegin,
        'rowEnd'   => $rowEnd
      ];

      $rowBegin = $rowEnd + 1;
      $_rows    = $allRows - $rowsFirstPage;

      while($_rows > $rowsOthersPage){
        $aux[] = [
          'page'     => $page++,
          'rowBegin' => $rowBegin,
          'rowEnd'   => $rowBegin + ( $rowsOthersPage - 1 )
        ];
        $allRows = $_rows;
        $rowBegin = $rowBegin + ( $rowsOthersPage - 1 );
        $rowBegin = $rowBegin + 1;
        $_rows = $allRows - $rowsOthersPage;
      }
      $aux[] = [
        'page'     => $page++,
        'rowBegin' => $rowBegin,
        'rowEnd'   => ($rowBegin + $_rows)-1
      ];
    }
    return $aux;
  }

  private function encabezadoTabla(){
    $this->pdf->SetTextColor(255,255,255);
    $this->pdf->SetFillColor(57,107,54);
    $this->pdf->Cell(8,5,'#',0,0,'C',true);
    $this->pdf->Cell(14,5,'Recibo',0,0,'C',true);
    $this->pdf->Cell(12,5,'Cancel.',0,0,'C',true);
    $this->pdf->Cell(35,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(75,5,utf8_decode('Descripción'),0,0,'C',true);
    $this->pdf->Cell(20,5,'F. Cancel.',0,0,'C',true);
    $this->pdf->Cell(10,5,'Cant.',0,0,'C',true);
    $this->pdf->Cell(16,5,'Precio',0,0,'C',true);
    $this->pdf->Cell(16,5,'Importe.',0,1,'C',true);
    $this->reset();
  }

  private function resumen($libros, $playeras, $_importeLibros, $_importePlayeras, $recibos, $cancelados){
    $this->pdf->SetFillColor(230,242,230);

    $this->pdf->Cell(41,5,'Libros','TBR',0,'C',true);
    $this->pdf->Cell(41,5,'  ( '.$libros.' )  '.'$ '.number_format($_importeLibros,2,'.',','),'TB',0,'',false);
    $this->pdf->Cell(41,5,'',0,0,'',false);
    $this->pdf->Cell(41,5,'Total del Reporte','TBR',0,'C',true);
    $this->pdf->Cell(41,5,'$ '.number_format($_importeLibros+$_importePlayeras,2,'.',','),'TB',1,'C',false);

    $this->pdf->Cell(41,5,'Playeras','TBR',0,'C',true);
    $this->pdf->Cell(41,5,'  ( '.$playeras.' )  '.'$ '.number_format($_importePlayeras, 2,'.',','),'TB',0,'',false);
    $this->pdf->Cell(41,5,'',0,0,'',false);
    $this->pdf->Cell(41,5,'Recibos','TBR',0,'C',true);
    $this->pdf->Cell(41,5,$recibos,'TB',1,'C',false);

    $this->pdf->Cell(41,5,'',0,0,'C',false);
    $this->pdf->Cell(41,5,'',0,0,'',false);
    $this->pdf->Cell(41,5,'',0,0,'',false);
    $this->pdf->Cell(41,5,'Cancelados','TBR',0,'C',true);
    $this->pdf->Cell(41,5,$cancelados,'TB',1,'C',false);

    $this->reset();
  }

  private function tituloPaginacion(){
    /*Titulo del reporte  y paginación*/
    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->Cell(150,8,'Reporte de ventas del dia: ','B',0,'L',false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(56,8,utf8_decode('Página ').$this->pdf->PageNo().' de {nb}','B',1,'R',false);
    $this->reset();
    /*Titulo del reporte  y paginación*/
  }

  private function espacio($alto){
    $this->pdf->Cell(0,$alto,'',0,1,'',false);
    $this->reset();
  }

  private function reset(){
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->SetFillColor(255,255,255);
  }
}
