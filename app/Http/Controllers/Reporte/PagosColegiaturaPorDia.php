<?php

namespace App\Http\Controllers\Reporte;

use App\Models\DetallePagoColegiatura;
use App\Models\PagoColegiatura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagosColegiaturaPorDia extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\PagosColegiaturaPorDia $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF($fecha){
   //$fecha = '2019-02-06';
   $cancelados = 0;
   $totalReporte = 0;
   $array_detalle=[];
   $numeroFila = 0;

   $rows = PagoColegiatura::whereDate('fecha_pago', $fecha)
     ->join('alumnos', 'pago_colegiaturas.alumno_id','=', 'alumnos.id')
     ->join('ciclos', 'pago_colegiaturas.ciclo_id','=','ciclos.id')
     ->join('grupos','pago_colegiaturas.grupo_id','=','grupos.id')
     ->select('pago_colegiaturas.*')
     ->addSelect( 'alumnos.id as alumnoid','alumnos.nombre1','alumnos.nombre2','alumnos.apellido1', 'alumnos.apellido2')
     ->addSelect('ciclos.periodo', 'grupos.nombre as grupo')
     ->orderBy('folio_recibo', 'asc')
     ->get();

   //return $rows;

   foreach($rows as $row){
     $numeroFila++;
     $alumno = utf8_decode($row->nombre1.' '.$row->nombre2.' '.$row->apellido1.' '.$row->apellido2);

     if($row->pago_cancelado) {
       $cancelados++;
       if($row->fecha_pago === $row->fecha_cancelacion){ $totalReporte = $totalReporte + 0; }
       if($row->fecha_cancelacion > $row->fecha_pago){ $totalReporte = $totalReporte + $row->cantidad_recibida_mxn;}
     }
     else{
       $totalReporte = $totalReporte + $row->cantidad_recibida_mxn;
     }

     $detalles = DetallePagoColegiatura::where('pago_id', $row->id)
       ->orderBy('orden_mes', 'asc')
       ->get();

     foreach ($detalles as $detalle){

       $recargo   = $detalle->importe_colegiatura * ($detalle->porcentaje_recargo/100);
       $descuento = $detalle->importe_colegiatura * ($detalle->porcentaje_descuento/100);

       if($row->pago_cancelado) {
         if($row->fecha_pago == $row->fecha_cancelacion){
           $array_detalle[] = [
             'numero'            => $numeroFila,
             'ciclo'             => $row->periodo,
             'recibo'            => $row->folio_recibo,
             'cancelado'         => $row->pago_cancelado ? 'Si' : '',
             'mes'               => substr($detalle->nombre_mes,0,3),
             'alumno'            => $alumno,
             'grupo'             => $row->grupo,
             'fecha_cancelacion' => $row->pago_cancelado ? $row->fecha_cancelacion->format('d-m-Y') : '',
             'colegiatura'       => 0.0,
             'recargo'           => 0.0,
             'descuento'         => 0.0,
             'total'             => 0.0
           ];
         }
         if($row->fecha_cancelacion > $row->fecha_pago){
           $array_detalle[] = [
             'numero'            => $numeroFila,
             'ciclo'             => $row->periodo,
             'recibo'            => $row->folio_recibo,
             'cancelado'         => $row->pago_cancelado ? 'Si' : '',
             'mes'               => substr($detalle->nombre_mes,0,3),
             'alumno'            => $alumno,
             'grupo'             => $row->grupo,
             'fecha_cancelacion' => $row->pago_cancelado ? $row->fecha_cancelacion->format('d-m-Y') : '',
             'colegiatura'       => $detalle->importe_colegiatura,
             'recargo'           => $recargo,
             'descuento'         => $descuento,
             'total'             => ($detalle->importe_colegiatura + $recargo) - $descuento
           ];
         }
       }
       else{
         $array_detalle[] = [
           'numero'            => $numeroFila,
           'ciclo'             => $row->periodo,
           'recibo'            => $row->folio_recibo,
           'cancelado'         => $row->pago_cancelado ? 'Si' : '',
           'mes'               => substr($detalle->nombre_mes,0,3),
           'alumno'            => $alumno,
           'grupo'             => $row->grupo,
           'fecha_cancelacion' => $row->pago_cancelado ? $row->fecha_cancelacion->format('d-m-Y') : '',
           'colegiatura'       => $detalle->importe_colegiatura,
           'recargo'           => $recargo,
           'descuento'         => $descuento,
           'total'             => ($detalle->importe_colegiatura + $recargo) - $descuento
         ];
       }



     }
   }
    $this->pdf->SetMargins('5','5','5');
    $this->pdf->SetAutoPageBreak(true,10);
    $this->pdf->AddPage('P','Letter');
    $this->pdf->AliasNbPages();

    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(44,6,utf8_decode('Reporte de Colegiaturas del día: '),'B',0,'L');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(55,6,$fecha,'B',0,'L');
    $this->pdf->Cell(10,6,'','B',0,'L');
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(20,6,utf8_decode('Ciclo Escolar:'),'B',0,'L');
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(0,6,$rows->count()!=0 ? $array_detalle[0]['ciclo'] : '','B',1,'L');

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
    $this->pdf->Cell(14,5,'Mes',0,0,'C',true);
    $this->pdf->Cell(50,5,'Alumo',0,0,'C',true);
    $this->pdf->Cell(20,5,'Grupo',0,0,'C',true);
    $this->pdf->Cell(20,5,'F. Cancel.',0,0,'C',true);
    $this->pdf->Cell(16,5,'Coleg.',0,0,'C',true);
    $this->pdf->Cell(16,5,'Descuento',0,0,'C',true);
    $this->pdf->Cell(16,5,'Rec.',0,0,'C',true);
    $this->pdf->Cell(20,5,'Total',0,1,'C',true);

    if($rows->count()!=0){
      $this->pdf->SetTextColor(0);
      $this->pdf->SetFont('Arial', '', 7);
      $this->pdf->SetFillColor(230,242,230);
      $i=1;
      foreach ($array_detalle as $clave => $fila){
        if($i%2===0){$fill = true;} else{$fill=false;}
        $this->pdf->Cell(8,5,$fila['numero'],'B',0,'C',$fill);
        $this->pdf->Cell(14,5,$fila['recibo'],'B',0,'C',$fill);
        $this->pdf->Cell(12,5,$fila['cancelado'],'B',0,'C',$fill);
        $this->pdf->Cell(14,5,$fila['mes'],'B',0,'C',$fill);
        $this->pdf->Cell(50,5,$fila['alumno'],'B',0,'L',$fill);
        $this->pdf->Cell(20,5,$fila['grupo'],'B',0,'C',$fill);
        $this->pdf->Cell(20,5,$fila['fecha_cancelacion'],'B',0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($fila['colegiatura'],2,'.',','),'B',0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($fila['descuento'],2,'.',','),'B',0,'C',$fill);
        $this->pdf->Cell(16,5,'$ '.number_format($fila['recargo'],2,'.',','),'B',0,'C',$fill);
        $this->pdf->Cell(20,5,'$ '.number_format($fila['total'],2,'.',','),'B',1,'C',$fill);
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
