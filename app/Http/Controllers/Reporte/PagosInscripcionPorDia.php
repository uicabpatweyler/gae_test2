<?php

namespace App\Http\Controllers\Reporte;

use App\Models\PagoInscripcion;
use Carbon\Carbon;
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

    $cancelados = 0;
    $totalReporte = 0;
    $array_detalle=[];
    $numeroFila = 0;

    $this->pdf->SetMargins('5','5','5');
    $this->pdf->SetAutoPageBreak(true,10);
    $this->pdf->AddPage('P','Letter');
    $this->pdf->AliasNbPages();

    $rows = PagoInscripcion::whereDate('fecha', $fecha)
      ->join('alumnos', 'pago_inscripciones.alumno_id','=', 'alumnos.id')
      ->join('ciclos', 'pago_inscripciones.ciclo_id','=','ciclos.id')
      ->join('grupos','pago_inscripciones.grupo_id','=','grupos.id')
      ->select('pago_inscripciones.*')
      ->addSelect( 'alumnos.id as alumno_id','alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
      ->addSelect( 'alumnos.created_at as at_created')
      ->addSelect('ciclos.periodo', 'grupos.nombre as grupo')
      ->orderBy('folio_recibo', 'asc')
      ->get();

    foreach ($rows as $row) {
      if($row->pago_cancelado) {
        $cancelados++;
        if($row->fecha === $row->fecha_cancelacion){ $totalReporte = $totalReporte + 0; }
        if($row->fecha_cancelacion > $row->fecha){ $totalReporte = $totalReporte + $row->cantidad_recibida_mxn;}
      }
      else{
        $totalReporte = $totalReporte + $row->cantidad_recibida_mxn;
      }
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(44,6,utf8_decode('Reporte de Inscripciones del día:'),'B',0,'L');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(55,6,' '.$fecha,'B',0,'L');
    $this->pdf->Cell(10,6,'','B',0,'L');
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(20,6,utf8_decode('Ciclo Escolar:'),'B',0,'L');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(0,6,$rows->count()!=0 ? $rows[0]['periodo'] : '','B',1,'L');

    $this->pdf->Cell(0,1,'',0,1,'',false);

    $this->pdf->SetFillColor(230,242,230);
    $this->pdf->Cell(0,2,'',0,1,false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,'Total del Reporte','TB',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,'$ '.number_format($totalReporte,2,'.',','),'TB',1,'C',false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Número de Recibos'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,$rows->count(),'B',1,'C',false);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(130,5,'',0,0,false);
    $this->pdf->Cell(38,5,utf8_decode('Recibos Cancelados'),'B',0,'L',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(38,5,$cancelados,'B',1,'C',false);
    //Espacio para la siguiente linea
    $this->pdf->Cell(0,2,'',0,1);

    $this->pdf->SetFont('Arial', 'B', 7);
    $this->pdf->SetTextColor(255,255,255);
    $this->pdf->SetFillColor(57,107,54);
    $this->pdf->SetFont('Arial', 'B', 7);
    $this->pdf->Cell(8,5,'#',0,0,'C',true);
    $this->pdf->Cell(14,5,'Recibo',0,0,'C',true);
    $this->pdf->Cell(12,5,'Cancel.',0,0,'C',true);
    $this->pdf->Cell(40,5,'Matricula',0,0,'C',true);
    $this->pdf->Cell(50,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(25,5,'Grupo',0,0,'C',true);
    $this->pdf->Cell(30,5,'Fecha',0,0,'C',true);
    $this->pdf->Cell(25,5,'Inscricpion',0,1,'C',true);



    if($rows->count()!=0){
      $this->pdf->SetTextColor(0);
      $this->pdf->SetFont('Arial', '', 7);
      $this->pdf->SetFillColor(230,242,230);
      $i=1;

      foreach ($rows as $row) {
        $alumno = utf8_decode($row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2);
        if($row->alumno_id<1000){
          $matricula = "00"."$row->alumno_id - ".(new Carbon($row->at_created))->format('dmY');
        }else{
          $matricula = "$row->alumno_id - ".(new Carbon($row->at_created))->format('dmY');
        }

        if($i%2===0){$fill = true;} else{$fill=false;}
        $this->pdf->Cell(8,5,$i,0,0,'C',$fill);
        $this->pdf->Cell(14,5,$row->folio_recibo,0,0,'C',$fill);
        $this->pdf->Cell(12,5,$row->pago_cancelado ? 'Si' : '',0,0,'C',$fill);
        $this->pdf->Cell(40,5,$matricula,0,0,'C',$fill);
        $this->pdf->Cell(50,5,$alumno,0,0,'L',$fill);
        $this->pdf->Cell(25,5,$row->grupo,0,0,'C',$fill);
        $this->pdf->Cell(30,5,$row->fecha->format('Y-m-d'),0,0,'C',$fill);
        $this->pdf->Cell(25,5,'$ '.number_format($row->importe_cuota,2,'.',','),0,1,'C',$fill);
        $i++;
      }
    }

    $this->pdf->SetTextColor(0);
    $this->pdf->SetX(0);
    $this->pdf->SetY(250);
    $this->pdf->Cell(0,0,'',0,1);
    $this->pdf->Cell(62,1,'','B',0);
    $this->pdf->Cell(10,1,'',0,0);
    $this->pdf->Cell(62,1,'','B',0);
    $this->pdf->Cell(10,1,'',0,0);
    $this->pdf->Cell(62,1,'','B',1);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(62,4,utf8_decode('María del Carmén Kantun Cupul'),0,0,'C');
    $this->pdf->Cell(10,4,'',0,0);
    $this->pdf->Cell(62,4,utf8_decode('Gaspar Felipe Sandoval Gómez'),0,0,'C');
    $this->pdf->Cell(10,4,'',0,0);
    $this->pdf->Cell(62,4,utf8_decode('Mtra. Flor Patrón'),0,1,'C');
    $this->pdf->Cell(62,3,'Encargada de Caja',0,0,'C');
    $this->pdf->Cell(10,3,'',0,0);
    $this->pdf->Cell(62,3,'Control Escolar',0,0,'C');
    $this->pdf->Cell(10,3,'',0,0);
    $this->pdf->Cell(62,3,'Directora',0,1,'C');

    $this->pdf->Output();
    exit;

  }
}
