<?php

namespace App\Http\Controllers\Reporte;

use App\Models\Alumno;
use App\Models\Config\Grado;
use App\Models\PagoInscripcion;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagosInscripcionPorDia extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\PagosInscripcionPorDia $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF($fecha){
    $numeroRecibos = 0;
    $recibosCancelados = 0;
    $totalReporte = 0;
    $rows = [];
    $numLinea = 1;

    $pagos = PagoInscripcion::whereDate('fecha', $fecha)
      ->join('alumnos', 'pago_inscripciones.alumno_id','=', 'alumnos.id')
      ->join('ciclos', 'pago_inscripciones.ciclo_id','=','ciclos.id')
      ->join('grupos','pago_inscripciones.grupo_id','=','grupos.id')
      ->select('pago_inscripciones.*')
      ->addSelect( 'alumnos.id as alumno_id','alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->addSelect( 'alumnos.created_at as at_created')
      ->addSelect('ciclos.periodo', 'grupos.nombre as grupo')
      ->orderBy('folio_recibo', 'asc')
      ->get();

    foreach ($pagos as $pago) {
      $numeroRecibos++;
      $cancelType = 0;
      $alumno = utf8_decode($pago->nombre1.' '.$pago->nombre2.' '.$pago->apellido1.' '.$pago->apellido2);
      if($pago->pago_cancelado){
        $recibosCancelados++;
        if($pago->fecha->equalTo($pago->fecha_cancelacion)){
          $totalReporte = $totalReporte + 0;
          $cancelType = 1;
        }
        else{
          $totalReporte = $totalReporte + $pago->cantidad_recibida_mxn;
        }
      }
      else{
        $totalReporte = $totalReporte + ($pago->cantidad_concepto * $pago->importe_cuota);
      }

      $rows[] = [
        'ciclo'     => $pago->periodo,
        'numero'    => $numLinea,
        'recibo'    => $pago->serie_recibo.'-'.$pago->folio_recibo,
        'cancelado' => $pago->pago_cancelado ? 'Si' : '',
        'fecha_cancel' => $pago->pago_cancelado ? $pago->fecha_cancelacion->format('d-m-Y') : '',
        'matricula'    => Alumno::find($pago->alumno_id)->matricula,
        'alumno'    => $alumno,
        'nivel'     => Grado::find($pago->grado_id)->nombre,
        'grupo'     => $pago->grupo,
        'importe'   => $cancelType === 1 ? 0 : $pago->importe_cuota,
      ];
      $numLinea++;
    }

    $data = $this->detailsRowsReport(count($rows));
    
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->SetAutoPageBreak(true,20);
    $this->pdf->AliasNbPages();

    for($pagina = 0; $pagina < count($data); $pagina++){
      $this->pdf->AddPage('P','Letter');
      $this->tituloPaginacion($fecha, $rows[0]['ciclo']);
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
        $this->pdf->Cell(14,5,$rows[$_x]['cancelado'],0,0,'C',$fill);
        $this->pdf->Cell(16,5,$rows[$_x]['fecha_cancel'],0,0,'C',$fill);
        $this->pdf->Cell(35,5,$rows[$_x]['matricula'],0,0,'C',$fill);
        $this->pdf->Cell(55,5,$rows[$_x]['alumno'],0,0,'L',$fill);
        $this->pdf->Cell(14,5,$rows[$_x]['nivel'],0,0,'C',$fill);
        $this->pdf->Cell(25,5,$rows[$_x]['grupo'],0,0,'C',$fill);
        $this->pdf->Cell(25,5,'$ '.number_format($rows[$_x]['importe'],2,'.',','),0,1,'R',$fill);
      }
    }

    $this->pdf->Output();
    exit;
  }

  private function tituloPaginacion($date, $ciclo){
    $shortDayOfWeek = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
    $nameMonths     = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre',' Diciembre'];
    $fecha = (new Carbon($date));
    $_fecha = $shortDayOfWeek[$fecha->dayOfWeek].' '.$fecha->day.', '.$nameMonths[$fecha->month-1].' '.$fecha->year;

    /*Titulo del reporte  y paginación*/
    $this->pdf->SetFont('Arial', '', 9);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->Cell(60,8,utf8_decode('Reporte de pagos de inscripción del día: '),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->Cell(50,8,utf8_decode($_fecha),'B',0,'L',false);
    $this->pdf->SetFont('Arial', '', 9);
    $this->pdf->Cell(21,8,'Ciclo:','B',0,'C', false);
    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->Cell(25,8,$ciclo,'B',0,'L', false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(50,8,utf8_decode('Página ').$this->pdf->PageNo().' de {nb}','B',1,'R',false);
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
    $this->pdf->SetFont('Arial', 'B', 7);
    $this->pdf->Cell(8,5,'#',0,0,'C',true);
    $this->pdf->Cell(14,5,'Recibo',0,0,'C',true);
    $this->pdf->Cell(14,5,'Cancelado',0,0,'C',true);
    $this->pdf->Cell(16,5,'F. Cancel',0,0,'C',true);
    $this->pdf->Cell(35,5,'Matricula',0,0,'C',true);
    $this->pdf->Cell(55,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(14,5,'Nivel',0,0,'C',true);
    $this->pdf->Cell(25,5,'Grupo',0,0,'C',true);
    $this->pdf->Cell(25,5,'Importe',0,1,'C',true);
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
