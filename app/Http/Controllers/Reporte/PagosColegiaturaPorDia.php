<?php

namespace App\Http\Controllers\Reporte;

use App\Models\DetallePagoColegiatura;
use App\Models\PagoColegiatura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class PagosColegiaturaPorDia extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\PagosColegiaturaPorDia $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF($fecha){
    $numeroRecibos = 0;
    $recibosCancelados = 0;
    $totalReporte = 0;

    $pagos = PagoColegiatura::whereDate('fecha_pago', $fecha)
      ->join('alumnos', 'pago_colegiaturas.alumno_id','=', 'alumnos.id')
      ->join('ciclos', 'pago_colegiaturas.ciclo_id','=','ciclos.id')
      ->join('grupos','pago_colegiaturas.grupo_id','=','grupos.id')
      ->select('pago_colegiaturas.*')
      ->addSelect( 'alumnos.id as alumnoid','alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->addSelect('ciclos.periodo', 'grupos.nombre as grupo')
      ->orderBy('folio_recibo', 'asc')
      ->get();

    $rows = [];
    $numLinea = 1;

    foreach ($pagos as $pago) {
      $cancelType = 0;
      $numeroRecibos++;
      $alumno = utf8_decode($pago->nombre1.' '.$pago->nombre2.' '.$pago->apellido1.' '.$pago->apellido2);

     if($pago->pago_cancelado){
       $recibosCancelados++;
       $totalReporte = $totalReporte + 0;
     }
     else{
       $totalReporte = $totalReporte + $pago->cantidad_recibida_mxn;
     }


    $detalles = DetallePagoColegiatura::where('pago_id', $pago->id)
      ->orderBy('orden_mes', 'asc')
      ->get();

    foreach ($detalles as $detalle) {
      $recargo   = $detalle->importe_colegiatura * ($detalle->porcentaje_recargo/100);
      $descuento = $detalle->importe_colegiatura * ($detalle->porcentaje_descuento/100);
      $rows[] = [
        'numero'            => $numLinea,
        'ciclo'             => $pago->periodo,
        'recibo'            => $pago->serie_recibo.'-'.$pago->folio_recibo,
        'cancelado'         => $pago->pago_cancelado ? 'Si' : '',
        'mes'               => substr($detalle->nombre_mes,0,3),
        'alumno'            => $alumno,
        'grupo'             => $pago->grupo,
        'fecha_cancelacion' => $pago->pago_cancelado ? $pago->fecha_cancelacion->format('d-m-Y') : '',
        'colegiatura'       => $detalle->importe_colegiatura,
        'recargo'           => $recargo,
        'descuento'         => $descuento,
        'total'             => ($detalle->importe_colegiatura + $recargo) - $descuento
      ];
    } //foreach tabla detalle_pago_colegiaturas
    $numLinea++;
    } //foreach tabla pagos_colegiaturas

    //return $recibosCancelados++;

    $data = $this->detailsRowsReport(count($rows));

    $this->pdf->SetMargins(5,5,5);
    $this->pdf->SetAutoPageBreak(true,20);
    $this->pdf->AliasNbPages();

    for($pagina = 0; $pagina < count($data); $pagina++){
      $this->pdf->AddPage('P','Letter');
      $this->tituloPaginacion($fecha);
      $this->espacio(5);
      if($data[$pagina]['page'] === 1){
        $this->resumen($totalReporte,$numeroRecibos,$recibosCancelados);
        $this->espacio(5);
      }
      $this->encabezadoTabla();
      $_begin = $data[$pagina]['rowBegin'];
      $_end   = $data[$pagina]['rowEnd'];

      $this->pdf->SetFillColor(230,242,230);
      $this->pdf->SetFont('Arial', '', 7);

      for($_x = $_begin-1; $_x < $_end; $_x++){
        $fill = $_x % 2 ? true : false;
        $this->pdf->Cell(8,5,$rows[$_x]['numero'],0,0,'C',$fill);
        $this->pdf->Cell(14,5,$rows[$_x]['recibo'],0,0,'C',$fill);
        $this->pdf->Cell(12,5,$rows[$_x]['cancelado'],0,0,'C',$fill);
        $this->pdf->Cell(14,5,$rows[$_x]['mes'],0,0,'C',$fill);
        $this->pdf->Cell(50,5,$rows[$_x]['alumno'],0,0,'L',$fill);
        $this->pdf->Cell(20,5,$rows[$_x]['grupo'],0,0,'C',$fill);
        $this->pdf->Cell(20,5,$rows[$_x]['fecha_cancelacion'],0,0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($rows[$_x]['colegiatura'],2,'.',','),0,0,'R',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($rows[$_x]['descuento'],2,'.',','),0,0,'R',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($rows[$_x]['recargo'],2,'.',','),0,0,'R',$fill);
        $this->pdf->Cell(20,5,'$ '.number_format($rows[$_x]['total'],2,'.',','),0,1,'R',$fill);
      }
    }

    $this->pdf->Output();
    exit;
  }

  private function tituloPaginacion($date){
    $shortDayOfWeek = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
    $nameMonths     = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre',' Diciembre'];
    $fecha = (new Carbon($date));
    $_fecha = $shortDayOfWeek[$fecha->dayOfWeek].' '.$fecha->day.', '.$nameMonths[$fecha->month-1].' '.$fecha->year;

    /*Titulo del reporte  y paginación*/
    $this->pdf->SetFont('Arial', '', 9);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->Cell(50,8,utf8_decode('Reporte de colegiaturas del día: '),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->Cell(100,8,utf8_decode($_fecha),'B',0,'L',false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(56,8,utf8_decode('Página ').$this->pdf->PageNo().' de {nb}','B',1,'R',false);
    $this->reset();
    /*Titulo del reporte  y paginación*/
  }

  private function resumen($total, $recibos, $cancelados){
    $this->pdf->SetFillColor(230,242,230);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,'Total del Reporte','TB',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,'$ '.number_format($total,2,'.',','),'TB',1,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Número de Recibos'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,$recibos,'B',1,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Recibos Cancelados'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,$cancelados,'B',1,'C',true);
    $this->reset();
  }

  private function encabezadoTabla(){
    $this->pdf->SetFont('Arial', 'B', 7);
    $this->pdf->SetTextColor(255,255,255);
    $this->pdf->SetFillColor(57,107,54);
    $this->pdf->Cell(8,5,'#',0,0,'C',true);
    $this->pdf->Cell(14,5,'Recibo',0,0,'C',true);
    $this->pdf->Cell(12,5,'Cancel.',0,0,'C',true);
    $this->pdf->Cell(14,5,'Mes',0,0,'C',true);
    $this->pdf->Cell(50,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(20,5,'Grupo',0,0,'C',true);
    $this->pdf->Cell(20,5,'F. Cancel.',0,0,'C',true);
    $this->pdf->Cell(16,5,'Coleg.',0,0,'C',true);
    $this->pdf->Cell(16,5,'Descuento',0,0,'C',true);
    $this->pdf->Cell(16,5,'Rec.',0,0,'C',true);
    $this->pdf->Cell(20,5,'Total',0,1,'C',true);
    $this->reset();
  }

  private function detailsRowsReport($totalRows){
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
