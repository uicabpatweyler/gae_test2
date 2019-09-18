<?php

namespace App\Http\Controllers\Reporte;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Grupo;
use App\Models\Config\MesDePago;
use App\Models\DetallePagoColegiatura;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ListadoDeudores extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\ListaDeudores $pdf)
  {
    $this->pdf = $pdf;
  }
  public function printPDF($escuela, $ciclo, $grado, $mes)
  {
//    $escuela = 1;
//    $ciclo = 2;
//    $grado = 1;
//    $mes = "Agosto";
    $rows = [];
    $numLinea = 1;
    $totalColegiatura = 0;
    $totalRecargo = 0;
    $totalGlobal = 0;
    $rowRecargo = 0;

    $rowCiclo = Ciclo::find($ciclo);

    $grupos = Grupo::orderBy('nombre')
      ->where('escuela_id', $escuela)
      ->where('ciclo_id', $ciclo)
      ->where('grado_id', $grado)
      ->with('grado')
      ->with('colegiatura')
      ->get();

    foreach ($grupos as $grupo)
    {
      $alumnos = Alumno::select('alumnos.*')
        ->join('inscripciones', 'alumnos.id','=', 'inscripciones.alumno_id')
        ->where('inscripciones.grupo_id', '=', $grupo->id)
        ->where('inscripciones.pago_id','<>', 0)
        ->where('inscripciones.baja_id', '=', 0)
        ->orderBy('alumnos.apellido1', 'asc')
        ->orderBy('alumnos.apellido2', 'asc')
        ->get();

      $month = MesDePago::where('cuota_id', $grupo->cuotacolegiatura_id)
        ->where('mes', $mes)
        ->first();
      $diffInDays = Carbon::now()->diffInDays($month->fecha2,false);

      foreach ($alumnos as $alumno)
      {
        $rowPay = DetallePagoColegiatura::where('escuela_id', $escuela)
          ->where('ciclo_id', $ciclo)
          ->where('alumno_id', $alumno->id)
          ->where('nombre_mes', $mes)
          ->where('pago_cancelado', false)
          ->first();

        if($rowPay===null){
          $totalColegiatura = $totalColegiatura + $grupo->colegiatura->cantidad;
          $rowRecargo = $diffInDays < 0 ? ($month->recargo/100)*$grupo->colegiatura->cantidad : 0;
          $totalRecargo = $totalRecargo + $rowRecargo;
          $rows[] = [
            'numero' => $numLinea++,
            'alumno' => $alumno->apellido1.' '.$alumno->apellido2.' '.$alumno->nombre1.' '.$alumno->nombre2,
            'grado'  => $grupo->grado->nombre,
            'grupo'  => $grupo->nombre,
            'mes'    => $mes,
            'cuota'  => $grupo->colegiatura->cantidad,
            'recargo' => $rowRecargo,
            'importe' => $grupo->colegiatura->cantidad + $rowRecargo
          ];
        }
      }
    }

    $data = $this->detailsRowsReport(count($rows));

    $this->pdf->SetMargins(5,5,5);
    $this->pdf->SetAutoPageBreak(true,20);
    $this->pdf->AliasNbPages();

    for($pagina = 0; $pagina < count($data); $pagina++){
      $this->pdf->AddPage('P','Letter');
      $this->tituloPaginacion($mes, $rowCiclo->periodo);
      $this->espacio(5);
      if($data[$pagina]['page'] === 1){
        $this->resumen($totalColegiatura,$totalRecargo);
        $this->espacio(5);
      }
      $this->encabezadoTabla();
      $_begin = $data[$pagina]['rowBegin'];
      $_end   = $data[$pagina]['rowEnd'];

      $this->pdf->SetFillColor(230,242,230);
      $this->pdf->SetFont('Arial', '', 7);

      for($_x = $_begin-1; $_x < $_end; $_x++) {
        $fill = $_x % 2 ? true : false;
        $this->pdf->Cell(8,5,$rows[$_x]['numero'],0,0,'C',$fill);
        $this->pdf->Cell(58,5,utf8_decode($rows[$_x]['alumno']),0,0,'L',$fill);
        $this->pdf->Cell(20,5,utf8_decode($rows[$_x]['grado']),0,0,'C',$fill);
        $this->pdf->Cell(20,5,utf8_decode($rows[$_x]['grupo']),0,0,'C',$fill);
        $this->pdf->Cell(25,5,utf8_decode($rows[$_x]['mes']),0,0,'C',$fill);
        $this->pdf->Cell(25,5,'$ '.number_format($rows[$_x]['cuota'],2,'.',','),0,0,'C',$fill);
        $this->pdf->Cell(25,5,'$ '.number_format($rows[$_x]['recargo'],2,'.',','),0,0,'C',$fill);
        $this->pdf->Cell(25,5,'$ '.number_format($rows[$_x]['importe'],2,'.',','),0,1,'C',$fill);
      }
    }

    $this->pdf->Output();
    exit;
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

  private function tituloPaginacion($mes, $ciclo){
    /*Titulo del reporte  y paginación*/
    $this->pdf->SetFont('Arial', '', 9);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->Cell(80,8,utf8_decode('Reporte de alumnos deudores del mes de: '),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->Cell(70,8,utf8_decode($mes.' '.$ciclo),'B',0,'L',false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(56,8,utf8_decode('Página ').$this->pdf->PageNo().' de {nb}','B',1,'R',false);
    $this->reset();
    /*Titulo del reporte  y paginación*/
  }

  private function resumen($total, $recargo){
    $this->pdf->SetFillColor(230,242,230);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,'Colegiatura','TB',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,'$ '.number_format($total,2,'.',','),'TB',1,'R',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Recargo'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,'$ '.number_format($recargo,2,'.',','),'B',1,'R',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Total'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,'$ '.number_format($total+$recargo,2,'.',','),'B',1,'R',true);
    $this->reset();
  }

  private function encabezadoTabla(){
    $this->pdf->SetFont('Arial', 'B', 7);
    $this->pdf->SetTextColor(255,255,255);
    $this->pdf->SetFillColor(57,107,54);
    $this->pdf->Cell(8,5,'#',0,0,'C',true);
    $this->pdf->Cell(58,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(20,5,'Grado',0,0,'C',true);
    $this->pdf->Cell(20,5,'Grupo',0,0,'C',true);
    $this->pdf->Cell(25,5,'Mes',0,0,'C',true);
    $this->pdf->Cell(25,5,'Colegiatura',0,0,'C',true);
    $this->pdf->Cell(25,5,'Recargo',0,0,'C',true);
    $this->pdf->Cell(25,5,'Importe',0,1,'C',true);
    $this->reset();
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
