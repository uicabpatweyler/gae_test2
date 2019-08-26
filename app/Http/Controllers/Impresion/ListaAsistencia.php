<?php

namespace App\Http\Controllers\Impresion;

use App\Models\Config\Grupo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ListaAsistencia extends Controller
{
  protected $pdf;
  public function __construct(\App\ModelsPdf\ListaDeAsistencia $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPdf($grupo,$mes,$teacher,$fecha){

    $diasHabiles = $this->diasHabiles($mes);
    $width = number_format((110/(count($diasHabiles))),2);
    $hombres = 0;
    $mujeres  = 0;

    $data = Grupo::find($grupo);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->SetAutoPageBreak(true,20);
    $this->pdf->AliasNbPages();
    $this->pdf->AddPage('P','Letter');
    $this->espacio(2);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(68,5,utf8_decode('LISTA DE ASISTENCIA DEL GRUPO'),1,0,'C',true);
    $this->pdf->Cell(68,5,utf8_decode('DEL MES DE'),1,0,'C',true);
    $this->pdf->Cell(70,5,'CICLO ESCOLAR',1,1,'C',true);
    $this->pdf->SetFont('Arial', 'I', 8);
    $this->pdf->Cell(68,5,utf8_decode($data->grado->nombre.' - '.$data->nombre),1,0,'C',false);
    $this->pdf->Cell(68,5,utf8_decode($mes),1,0,'C',false);
    $this->pdf->Cell(70,5,$data->ciclo->periodo,1,1,'C',false);
    $this->espacio(3);
    $this->reset();

    $this->pdf->Cell(6,5,'',0,0,'C',false);
    $this->pdf->Cell(90,5,'',0,0,'C',false);

    $this->pdf->SetFont('Arial', '', 7);
    $this->pdf->SetFillColor(234,234,234); //Gris Claro

    for ($i=0;$i<count($diasHabiles);$i++){
      $dia = explode('-',$diasHabiles[$i]);
      if($i==count($diasHabiles)-1){
        $this->pdf->Cell($width,5,$dia[0],1,1,'C',true);
      }
      else{
        $this->pdf->Cell($width,5,$dia[0],1,0,'C',true);
      }
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetFillColor(196,224,180); //Verde

    $this->pdf->Cell(6,5,'#',1,0,'C',true);
    $this->pdf->Cell(90,5,'Alumno',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 7);
    $this->pdf->SetFillColor(234,234,234); //Gris Claro
    for ($i=0;$i<count($diasHabiles);$i++){
      $dia = explode('-',$diasHabiles[$i]);
      if($i==count($diasHabiles)-1){
        $this->pdf->Cell($width,5,$dia[1],1,1,'C',true);
      }
      else{
        $this->pdf->Cell($width,5,$dia[1],1,0,'C',true);
      }
    }

    $alumnos = DB::table('alumnos')
      ->join('inscripciones', 'alumnos.id','=', 'inscripciones.alumno_id')
      ->addSelect('alumnos.*')
      ->where('inscripciones.grupo_id', '=', $grupo)
      ->where('inscripciones.pago_id','<>', 0)
      ->where('inscripciones.baja_id', '=', 0)
      ->orderBy('alumnos.nombre1', 'asc')
      ->orderBy('alumnos.nombre2', 'asc')
      ->get();

    $this->reset();
    $numero = 1;

    foreach ($alumnos as $alumno){
      $alumno->genero === 'H' ? $hombres++ : $mujeres++;
      if(($numero%2)==0){
        $this->pdf->SetFillColor(234,234,234); //Gris Claro
        $this->pdf->Cell(6,5,$numero,1,0,'C',true);
        $this->pdf->Cell(90,5,utf8_decode($alumno->nombre1.' '.$alumno->nombre2.' '.$alumno->apellido1.' '.$alumno->apellido2),1,0,'L',true);
        $this->cuadricula($diasHabiles,true);
      }
      else{
        $this->pdf->SetFillColor(255,255,255); //Blanco
        $this->pdf->Cell(6,5,$numero,1,0,'C',true);
        $this->pdf->Cell(90,5,utf8_decode($alumno->nombre1.' '.$alumno->nombre2.' '.$alumno->apellido1.' '.$alumno->apellido2),1,0,'L',true);
        $this->cuadricula($diasHabiles,true);
      }
      $numero++;
    }

    $this->espacio(5);
    $this->reset();

    $this->pdf->SetFont('Arial', 'B', 8);
    //Espacio
    $this->pdf->Cell(0,5,'',0,1,'C',false);
    $this->pdf->Cell(6,5,'',0,0,'C',false);
    $this->pdf->Cell(45,5,'Total de alumnos: '.$alumnos->count(),0,0,'L',false);
    $this->pdf->Cell(45,5,'Hombres: '.$hombres,0,0,'C',false);
    $this->pdf->Cell(45,5,'Mujeres: '.$mujeres,0,1,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetFillColor(196,224,180); //Verde
    $this->espacio(5);
    $this->reset();
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetFillColor(196,224,180); //Verde
    $this->pdf->Cell(80,5,'Teacher',1,0,'C',true);
    $this->pdf->Cell(60,5,'Fecha de Entrega',1,0,'C',true);
    $this->pdf->Cell(66,5,utf8_decode('Fecha de devolución'),1,1,'C',true);
    $this->pdf->Cell(80,5,utf8_decode($teacher),1,0,'C',false);
    $this->pdf->Cell(60,5,$fecha,1,0,'C',false);
    $this->pdf->Cell(66,5,'',1,0,'C',false);

    $this->pdf->Output();
    exit;
  }

  private function cuadricula($diasLista,$fill){
    $width = number_format((110/(count($diasLista))),2);
    for($i=0;$i<count($diasLista);$i++){
      if($i==count($diasLista)-1){
        $this->pdf->Cell($width,5,'',1,1,'C',$fill);
      }
      else{
        $this->pdf->Cell($width,5,'',1,0,'C',$fill);
      }
    }
  }

  private function diasHabiles($mes){
    $info           = explode('-',$mes);
    $diasDelMes     = Carbon::createFromDate($info[1],$this->getNumberMonth($info[0]),1)->daysInMonth;
    $shortDayOfWeek = array('D','L','M','M','J','V','S');
    $diasHabiles    = [];
    $index          = 0;
    for($i=1; $i<=$diasDelMes; $i++){
      $fecha     = Carbon::createFromDate($info[1],$this->getNumberMonth($info[0]),$i);
      $diaSemana =  $shortDayOfWeek[$fecha->dayOfWeek];
      if($fecha->dayOfWeek==0 || $fecha->dayOfWeek==6){}
      else{
        $diasHabiles[$index] = $diaSemana.'-'.$fecha->format('d');
        $index++;
      }
    }
    return $diasHabiles;
  }

  private function getNumberMonth($month){
    switch($month){
      case "Enero":
        return 1;
        break;
      case "Febrero":
        return 2;
        break;
      case "Marzo":
        return 3;
        break;
      case "Abril":
        return 4;
        break;
      case "Mayo":
        return 5;
        break;
      case "Junio":
        return 6;
        break;
      case "Julio":
        return 7;
        break;
      case "Agosto":
        return 8;
        break;
      case "Septiembre":
        return 9;
        break;
      case "Octubre":
        return 10;
        break;
      case "Noviembre":
        return 11;
        break;
      case "Diciembre":
        return 12;
        break;
    }
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
