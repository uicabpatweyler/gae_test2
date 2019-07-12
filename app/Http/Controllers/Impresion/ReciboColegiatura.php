<?php

namespace App\Http\Controllers\Impresion;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\DetallePagoColegiatura;
use App\Models\InformacionAlumno;
use App\Models\PagoColegiatura;
use App\Models\Tutor;
use App\Http\Controllers\Controller;
use App\Helpers\Convertidor;

class ReciboColegiatura extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\ReciboColegiatura $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF(PagoColegiatura $pagoColegiatura){

    $pago = $pagoColegiatura;
    $grado = Grado::find($pago->grado_id);
    $grupo = Grupo::find($pago->grupo_id);
    $ciclo = Ciclo::find($pago->ciclo_id);
    $alumno = Alumno::find($pago->alumno_id);
    $infoAlumno = InformacionAlumno::where('escuela_id', $pago->escuela_id)
      ->where('ciclo_id', $pago->ciclo_id)
      ->where('alumno_id', $pago->alumno_id)
      ->first();
    $tutor = Tutor::find($infoAlumno->tutor_id);
    $detalles = DetallePagoColegiatura::where('pago_id', $pago->id)
      ->orderBy('orden_mes','asc')
      ->get();

    $direccion = 'Calle Faisán # 147 entre Chablé y Retorno 3.';
    $direccion .= ' Chetumal, Q.Roo.';
    $direccion .= ' RFC: IMA-040824-R97';
    $direccion .= ' Tel. (983) 83 7 64 66';

    $this->pdf->AddPage('P','Letter');

    $this->pdf->Image('logo_left.png',10,20);
    $this->pdf->Image('logo_right.png',185,16);

    /*Empieza encabezado*/
    $this->pdf->SetFont('Times','BI', 14);
    $this->pdf->SetTextColor(0,128,0);

    $this->pdf->Cell(90,5,'IRLANDA Academy of English',0,0,'L');
    $this->pdf->Cell(16,5,'',0,0);
    $this->pdf->Cell(90,5,utf8_decode('Academia de Inglés IRLANDA'),0,1,'R');

    $this->pdf->SetFont('Arial', '', 8);

    $this->pdf->Cell(0,5,utf8_decode($direccion),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('INCORPORACIÓN A LA SEQ. C.C.T. 23PBT003'),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('NÚMERO DE ACUERDO DE INCORPORACIÓN: ICAT17001CT'),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('DE 20 DE FEBRERO DEL 2017'),0,1,'C');
    /*Termina encabezado*/

    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(0);
    $this->pdf->Cell(55,5,utf8_decode('RECIBO DE PAGO DE COLEGIATURA'),0,0,'L');
    $this->pdf->Cell(5,5,utf8_decode(''),0,0,'C');
    $this->pdf->Cell(76,5,utf8_decode('ESTE COMPROBANTE NO ES DEDUCIBLE DE I.S.R'),0,0,'C');
    $this->pdf->SetFont('Arial', 'B', 14);
    $this->pdf->Cell(30,5,utf8_decode('RECIBO'),0,0,'R');

    $this->pdf->SetFont('Arial', 'B', 15);
    $this->pdf->SetTextColor(255,0,0);
    $this->pdf->Cell(30,5,utf8_decode($pago->folio_recibo.''),0,1,'C');

    //Color para el relleno de celdas: Gris Claro
    $this->pdf->SetFillColor(234,234,234);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(18,5,'Fecha',1,0,'C',true);
    $this->pdf->Cell(20,5,$pago->fecha_pago->format('d-m-Y'),1,0,'C',false);
    $this->pdf->Cell(18,5,'Nivel',1,0,'C',true);
    $this->pdf->Cell(22,5,utf8_decode($grado->nombre),1,0,'C',false);
    $this->pdf->Cell(18,5,'Grupo',1,0,'C',true);
    $this->pdf->Cell(20,5,utf8_decode($grupo->nombre),1,0,'C',false);
    $this->pdf->Cell(14,5,'Ciclo',1,0,'C',true);
    $this->pdf->Cell(18,5,$ciclo->periodo,1,0,'C',false);
    $this->pdf->Cell(17,5,'Matricula',1,0,'C',true);
    $this->pdf->Cell(30,5,$alumno->matricula,1,0,'C',false);

    $this->pdf->Ln(8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(25,4,'Alumno',1,0,'C',true);
    $this->pdf->Cell(73,4,$alumno->full_name,1,0,'L',false);
    $this->pdf->Cell(25,4,'Tutor',1,0,'C',true);
    $this->pdf->Cell(73,4,$tutor->full_name,1,1,'L',false);
    $this->pdf->Cell(25,4,'Direccion',1,0,'C',true);
    $this->pdf->Cell(171,4,utf8_decode($infoAlumno->direccion.' '.$infoAlumno->colonia),1,0,'L',false);

    $this->pdf->Ln(6);

    $this->pdf->Cell(20,5,'Cantidad',1,0,'C',true);
    $this->pdf->Cell(60,5,'Concepto',1,0,'C',true);
    $this->pdf->Cell(28,5,'Colegiatura',1,0,'C',true);
    $this->pdf->Cell(28,5,'Recargo',1,0,'C',true);
    $this->pdf->Cell(28,5,'Descuento',1,0,'C',true);
    $this->pdf->Cell(32,5,'Importe',1,1,'C',true);

    $i=1;

    //Color para el relleno de las filas: Gris Claro
    $this->pdf->SetFillColor(234,234,234);

    $aux_subtotal = 0;

    foreach ($detalles as $detalle){
      $fill = ($i%2) == 0 ? true : false;
      $aux_recargo_pesos   = ($detalle->importe_colegiatura * ($detalle->porcentaje_recargo / 100));
      $aux_descuento_pesos = ($detalle->importe_colegiatura * ($detalle->porcentaje_descuento / 100));
      $aux_importe = ($detalle->importe_colegiatura + $aux_recargo_pesos) - $aux_descuento_pesos;
      $aux_subtotal = $aux_subtotal + $aux_importe;

      $this->pdf->Cell(20,5,$detalle->cantidad_concepto,'LR',0,'C',$fill);
      $this->pdf->Cell(60,5,'Colegiatura del Mes de '.$detalle->nombre_mes,'LR',0,'L',$fill);
      $this->pdf->Cell(28,5,'$ '.number_format($detalle->importe_colegiatura,2,'.',','),'LR',0,'C',$fill);
      if($detalle->porcentaje_recargo!=0){
        $this->pdf->Cell(28,5,'+ $ '.number_format($aux_recargo_pesos,2,'.',',').' ('.$detalle->porcentaje_recargo.'%)','LR',0,'C',$fill);
      }
      else{
        $this->pdf->Cell(28,5,'$ '.number_format($aux_recargo_pesos,2,'.',',').' ('.$detalle->porcentaje_recargo.'%)','LR',0,'C',$fill);
      }
      if($detalle->porcentaje_descuento){
        $this->pdf->Cell(28,5,'- $ '.number_format($aux_descuento_pesos,2,'.',',').' ('.$detalle->porcentaje_descuento.'%)','LR',0,'C',$fill);
      }
      else{
        $this->pdf->Cell(28,5,'$ '.number_format($aux_descuento_pesos,2,'.',',').' ('.$detalle->porcentaje_descuento.'%)','LR',0,'C',$fill);
      }
      $this->pdf->Cell(32,5,'$ '.number_format($aux_importe,2,'.',','),'LR',1,'R',$fill);
      $i++;
    }

    for($y=$i; $y<=12; $y++){
      $fill = ($i%2) == 0 ? true : false;
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(60,5,'','LR',0,'L',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(32,5,'','LR',1,'R',$fill);
      $i++;
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);

    $this->pdf->Cell(136,5,'Importe con letras:','T',0,'C',false);
    $this->pdf->Cell(28,5,'Total',1,0,'C',true);
    $this->pdf->Cell(32,5,'$ '.number_format($aux_subtotal,2,'.',','),1,1,'R',false);
    $this->pdf->Cell(136,5,Convertidor::numtoletras($aux_subtotal),0,0,'C',false);
    $this->pdf->Cell(28,5,'','T',0,'C',false);
    $this->pdf->Cell(32,5,'','T',1,'R',false);

    $this->pdf->Ln(2);

    /*Empieza encabezado*/
    $this->pdf->SetFont('Times','BI', 14);
    $this->pdf->SetTextColor(0,128,0);

    $this->pdf->Cell(90,5,'IRLANDA Academy of English',0,0,'L');
    $this->pdf->Cell(16,5,'',0,0);
    $this->pdf->Cell(90,5,utf8_decode('Academia de Inglés IRLANDA'),0,1,'R');

    $this->pdf->SetFont('Arial', '', 8);

    $this->pdf->Cell(0,5,utf8_decode($direccion),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('INCORPORACIÓN A LA SEQ. C.C.T. 23PBT003'),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('NÚMERO DE ACUERDO DE INCORPORACIÓN: ICAT17001CT'),0,1,'C');
    $this->pdf->Cell(0,5,utf8_decode('DE 20 DE FEBRERO DEL 2017'),0,1,'C');
    /*Termina encabezado*/

    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetTextColor(0);
    $this->pdf->Cell(55,5,utf8_decode('RECIBO DE PAGO DE COLEGIATURA'),0,0,'L');
    $this->pdf->Cell(5,5,utf8_decode(''),0,0,'C');
    $this->pdf->Cell(76,5,utf8_decode('ESTE COMPROBANTE NO ES DEDUCIBLE DE I.S.R'),0,0,'C');
    $this->pdf->SetFont('Arial', 'B', 14);
    $this->pdf->Cell(30,5,utf8_decode('RECIBO'),0,0,'R');

    $this->pdf->SetFont('Arial', 'B', 15);
    $this->pdf->SetTextColor(255,0,0);
    $this->pdf->Cell(30,5,utf8_decode($pago->folio_recibo.''),0,1,'C');

    //Color para el relleno de celdas: Gris Claro
    $this->pdf->SetFillColor(234,234,234);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(18,5,'Fecha',1,0,'C',true);
    $this->pdf->Cell(20,5,$pago->fecha_pago->format('d-m-Y'),1,0,'C',false);
    $this->pdf->Cell(18,5,'Nivel',1,0,'C',true);
    $this->pdf->Cell(22,5,utf8_decode($grado->nombre),1,0,'C',false);
    $this->pdf->Cell(18,5,'Grupo',1,0,'C',true);
    $this->pdf->Cell(20,5,utf8_decode($grupo->nombre),1,0,'C',false);
    $this->pdf->Cell(14,5,'Ciclo',1,0,'C',true);
    $this->pdf->Cell(18,5,$ciclo->periodo,1,0,'C',false);
    $this->pdf->Cell(17,5,'Matricula',1,0,'C',true);
    $this->pdf->Cell(30,5,$alumno->matricula,1,0,'C',false);

    $this->pdf->Ln(8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(25,4,'Alumno',1,0,'C',true);
    $this->pdf->Cell(73,4,$alumno->full_name,1,0,'L',false);
    $this->pdf->Cell(25,4,'Tutor',1,0,'C',true);
    $this->pdf->Cell(73,4,$tutor->full_name,1,1,'L',false);
    $this->pdf->Cell(25,4,'Direccion',1,0,'C',true);
    $this->pdf->Cell(171,4,utf8_decode($infoAlumno->direccion.' '.$infoAlumno->colonia),1,0,'L',false);

    $this->pdf->Ln(6);

    $this->pdf->Cell(20,5,'Cantidad',1,0,'C',true);
    $this->pdf->Cell(60,5,'Concepto',1,0,'C',true);
    $this->pdf->Cell(28,5,'Colegiatura',1,0,'C',true);
    $this->pdf->Cell(28,5,'Recargo',1,0,'C',true);
    $this->pdf->Cell(28,5,'Descuento',1,0,'C',true);
    $this->pdf->Cell(32,5,'Importe',1,1,'C',true);

    $i=1;

    //Color para el relleno de las filas: Gris Claro
    $this->pdf->SetFillColor(234,234,234);

    $aux_subtotal = 0;

    foreach ($detalles as $detalle){
      $fill = ($i%2) == 0 ? true : false;
      $aux_recargo_pesos   = ($detalle->importe_colegiatura * ($detalle->porcentaje_recargo / 100));
      $aux_descuento_pesos = ($detalle->importe_colegiatura * ($detalle->porcentaje_descuento / 100));
      $aux_importe = ($detalle->importe_colegiatura + $aux_recargo_pesos) - $aux_descuento_pesos;
      $aux_subtotal = $aux_subtotal + $aux_importe;

      $this->pdf->Cell(20,5,$detalle->cantidad_concepto,'LR',0,'C',$fill);
      $this->pdf->Cell(60,5,'Colegiatura del Mes de '.$detalle->nombre_mes,'LR',0,'L',$fill);
      $this->pdf->Cell(28,5,'$ '.number_format($detalle->importe_colegiatura,2,'.',','),'LR',0,'C',$fill);
      if($detalle->porcentaje_recargo!=0){
        $this->pdf->Cell(28,5,'+ $ '.number_format($aux_recargo_pesos,2,'.',',').' ('.$detalle->porcentaje_recargo.'%)','LR',0,'C',$fill);
      }
      else{
        $this->pdf->Cell(28,5,'$ '.number_format($aux_recargo_pesos,2,'.',',').' ('.$detalle->porcentaje_recargo.'%)','LR',0,'C',$fill);
      }
      if($detalle->porcentaje_descuento){
        $this->pdf->Cell(28,5,'- $ '.number_format($aux_descuento_pesos,2,'.',',').' ('.$detalle->porcentaje_descuento.'%)','LR',0,'C',$fill);
      }
      else{
        $this->pdf->Cell(28,5,'$ '.number_format($aux_descuento_pesos,2,'.',',').' ('.$detalle->porcentaje_descuento.'%)','LR',0,'C',$fill);
      }
      $this->pdf->Cell(32,5,'$ '.number_format($aux_importe,2,'.',','),'LR',1,'R',$fill);
      $i++;
    }

    for($y=$i; $y<=12; $y++){
      $fill = ($i%2) == 0 ? true : false;
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(60,5,'','LR',0,'L',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(28,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(32,5,'','LR',1,'R',$fill);
      $i++;
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);

    $this->pdf->Cell(136,5,'Importe con letras:','T',0,'C',false);
    $this->pdf->Cell(28,5,'Total',1,0,'C',true);
    $this->pdf->Cell(32,5,'$ '.number_format($aux_subtotal,2,'.',','),1,1,'R',false);
    $this->pdf->Cell(136,5,Convertidor::numtoletras($aux_subtotal),0,0,'C',false);
    $this->pdf->Cell(28,5,'','T',0,'C',false);
    $this->pdf->Cell(32,5,'','T',1,'R',false);

    $this->pdf->Output();
    exit;
  }
}
/*https://github.com/codedge/laravel-fpdf/issues/11*/
