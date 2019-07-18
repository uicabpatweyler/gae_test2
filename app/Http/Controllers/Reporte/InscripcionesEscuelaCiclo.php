<?php

namespace App\Http\Controllers\Reporte;

use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InscripcionesEscuelaCiclo extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\InscripcionesEscuelaCiclo $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF($escuela_id, $ciclo_id){
    $alumnosPermitidos = 0;
    $alumnosInscritos  = 0;
    $disponibles = 0;

    $ciclo = Ciclo::find($ciclo_id);
    $grados = Grado::orderBy('id','asc')->get();

    $this->pdf->SetMargins('5','5','5');
    $this->pdf->SetAutoPageBreak(true,10);
    $this->pdf->AddPage('P','Letter');
    $this->pdf->AliasNbPages();

    $this->pdf->SetFont('Arial', 'B', 9);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0,128,0);

    $this->pdf->Cell(0,8,'Reporte de Alumnos Inscritos por Grado y Grupo del Ciclo Escolar: '.$ciclo->periodo,'B',1,'C',false);
    $this->pdf->Cell(0,5,'',0,1,'',false);

    $this->pdf->SetTextColor(0);
    $i=1;

    foreach ($grados as $grado){

      $this->pdf->SetFont('Arial', 'B', 8);
      $this->pdf->SetTextColor(255,255,255);
      $this->pdf->SetFillColor(0,128,0);

      $this->pdf->Cell(0,5,$grado->nombre,0,1,'C',true);

      $grupos = Grupo::where('grado_id', $grado->id)
        ->where('escuela_id', $escuela_id)
        ->where('ciclo_id',$ciclo_id)
        ->orderBy('nombre', 'asc')
        ->get();

      $this->pdf->SetTextColor(0);
      $this->pdf->SetFillColor(230,242,230);
      $this->pdf->SetDrawColor(0);

      $this->pdf->setFont('Arial', 'B',8);
      $this->pdf->Cell(10,5,'#','B',0,'C',true);
      $this->pdf->Cell(58,5,'Grupo','B',0,'C',true);
      $this->pdf->Cell(58,5, 'Alumnos Permitidos','B',0,'C', true);
      $this->pdf->Cell(60,5, 'Alumnos Inscritos','B',0,'C', true);
      $this->pdf->Cell(20,5, 'Disponible(s)','B',1,'C', true);

      $this->pdf->setFont('Arial', '',8);
      foreach ($grupos as $grupo) {

        $inscritos = Inscripcion::where('grupo_id',$grupo->id)
          ->where('baja_id', 0)
          ->count();

        $alumnosPermitidos = $alumnosPermitidos + $grupo->cupoalumnos;
        $alumnosInscritos  = $alumnosInscritos + $inscritos;
        $disponibles       = $disponibles + ($grupo->cupoalumnos - $inscritos);

        $this->pdf->Cell(10,5,$i++,'BR',0,'C',false);
        $this->pdf->Cell(58,5,$grupo->nombre,'BR',0,'C', false);
        $this->pdf->Cell(58,5, $grupo->cupoalumnos,'BR',0,'C', false);
        $this->pdf->Cell(60,5, $inscritos,'BR',0,'C', false);
        $this->pdf->Cell(20,5, $grupo->cupoalumnos - $inscritos,'B',1,'C', false);

      }
      $this->pdf->Cell(0,3,'',0,1,'',false);
    }

    $this->pdf->setFont('Arial', 'B',9);

    $this->pdf->Cell(10,5,'','B',0,'C',false);
    $this->pdf->Cell(58,5,'Total','B',0,'C', false);
    $this->pdf->Cell(58,5,$alumnosPermitidos,'B',0,'C', false);
    $this->pdf->Cell(60,5,$alumnosInscritos,'B',0,'C', false);
    $this->pdf->Cell(20,5,$disponibles,'B',1,'C', false);

    $porcentaje = ($alumnosInscritos*100) / $alumnosPermitidos;

    $this->pdf->Cell(10,8,'','B',0,'C',false);
    $this->pdf->Cell(58,8,utf8_decode('Porcentaje de Inscripción'),'B',0,'R', false);
    $this->pdf->Cell(58,8,number_format($porcentaje,2).'%','B',0,'C', false);
    $this->pdf->Cell(60,8,'','B',0,'C', false);
    $this->pdf->Cell(20,8,'','B',1,'C', false);

    $this->pdf->Output();
    exit;
  }
}
