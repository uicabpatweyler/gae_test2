<?php

namespace App\Http\Controllers\Impresion;

use App\Helpers\Convertidor;
use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\InformacionAlumno;
use App\Models\SalidaProducto;
use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReciboVenta extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\ReciboVenta $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF(SalidaProducto $salidaProducto){

    $alumno = Alumno::find($salidaProducto->alumno_id);
    $grupo = Grupo::find($salidaProducto->grupo_id);
    $grado = Grado::find($grupo->grado_id);
    $ciclo = Ciclo::find($salidaProducto->ciclo_id);
    $infoAlumno = InformacionAlumno::where('escuela_id', $salidaProducto->escuela_id)
      ->where('ciclo_id', $salidaProducto->ciclo_id)
      ->where('alumno_id', $salidaProducto->alumno_id)
      ->first();
    $tutor = Tutor::find($infoAlumno->tutor_id);

    $productos = DB::table('detalle_salida_productos')
      ->join('productos','detalle_salida_productos.producto_id','=','productos.id')
      ->select('detalle_salida_productos.numero_linea', 'detalle_salida_productos.precio_unitario', 'detalle_salida_productos.cantidad')
      ->addSelect('productos.nombre_categoria', 'productos.nombre')
      ->where('salidaprod_id', '=', $salidaProducto->id)
      ->orderBy('detalle_salida_productos.numero_linea', 'asc')
      ->get();

    $direccion = 'Calle Faisán # 147 entre Chablé y Retorno 3.';
    $direccion .= ' Chetumal, Q.Roo.';
    $direccion .= ' RFC: IMA-040824-R97';
    $direccion .= ' Tel. (983) 83 7 64 66';

    $this->pdf->SetMargins('5','5','5');
    $this->pdf->AddPage('P','Letter');

    $this->pdf->Image('logo_left.png',10,15);
    $this->pdf->Image('logo_right.png',185,11);

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
    

    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetTextColor(0);
    $this->pdf->Cell(73,5,utf8_decode('RECIBO DE COMPRA'),0,0,'C');
    $this->pdf->Cell(60,5,utf8_decode(''),0,0,'C');
    $this->pdf->Cell(43,5,utf8_decode('RECIBO'),0,0,'R');
    $this->pdf->SetTextColor(255,0,0);
    $this->pdf->SetFont('Arial', 'B', 15);
    $this->pdf->Cell(30,5,($salidaProducto->folio_recibo <100) ? '000'.$salidaProducto->folio_recibo : '00'.$salidaProducto->folio_recibo,0,1,'C');

    $this->pdf->SetTextColor(0);
    $this->pdf->SetFillColor(234,234,234);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Fecha',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(28,5,$salidaProducto->fecha_venta->format('Y-m-d'),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Nivel',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(22,5,utf8_decode($grado->nombre),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Grupo',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(20,5,utf8_decode($grupo->nombre),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(14,5,'Ciclo',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(18,5,$ciclo->periodo,1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(20,5,'Matricula',1,0,'C',true);
    $this->pdf->Cell(30,5,$alumno->matricula,1,1,'C',false);

    $this->pdf->Cell(0,2,'',0,1);//Espacio


    $this->pdf->SetTextColor(0);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(28,4,'Alumno',1,0,'C',true);
    $this->pdf->Cell(75,4,utf8_decode($alumno->full_name),1,0,'L',false);
    $this->pdf->Cell(28,4,'Tutor',1,0,'C',true);
    $this->pdf->Cell(75,4,utf8_decode($tutor->full_name),1,1,'L',false);
    $this->pdf->Cell(28,4,'Direccion',1,0,'C',true);
    $this->pdf->Cell(178,4,utf8_decode($infoAlumno->direccion.' '.$infoAlumno->colonia),1,1,'L',false);

    $this->pdf->Cell(0,2,'',0,1,'',false);

    //Verde
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(10,5,'#',1,0,'C',true);
    $this->pdf->Cell(20,5,'Categoria',1,0,'C',true);
    $this->pdf->Cell(111,5,utf8_decode('Descripción del producto'),1,0,'C',true);
    $this->pdf->Cell(20,5,'Cantidad',1,0,'C',true);
    $this->pdf->Cell(20,5,'Prec. Unit.',1,0,'C',true);
    $this->pdf->Cell(25,5,'Importe',1,1,'C',true);

    $this->pdf->SetFillColor(234,234,234);

    $i=1;
    $importePorFila = 0;
    $importeTotal = 0;
    foreach ($productos as $producto){
      $fill = ($i%2) == 0 ? true : false;
      $importePorFila = $producto->cantidad * $producto->precio_unitario;
      $importeTotal = $importeTotal + $importePorFila;
      $this->pdf->Cell(10,5,$producto->numero_linea,'LR',0,'C',$fill);
      $this->pdf->Cell(20,5,utf8_decode($producto->nombre_categoria),'LR',0,'C',$fill);
      $this->pdf->Cell(111,5,utf8_decode($producto->nombre),'LR',0,'L',$fill);
      $this->pdf->Cell(20,5,$producto->cantidad,'LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'$ '.number_format($producto->precio_unitario,2,'.',','),'LR',0,'C',$fill);
      $this->pdf->Cell(25,5,'$ '.number_format($importePorFila,2,'.',','),'LR',1,'C',$fill);
      $i++;
    }

    for($y=$i; $y<=10; $y++){
      $fill = ($i%2) == 0 ? true : false;
      $this->pdf->Cell(10,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'L',$fill);
      $this->pdf->Cell(111,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(25,5,'','LR',1,'R',$fill);
      $i++;
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);

    //Verde
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(141,5,'Importe con letras:','T',0,'C',false);
    $this->pdf->Cell(40,5,'Total',1,0,'C',true);
    $this->pdf->Cell(25,5,'$ '.number_format($importeTotal,2,'.',','),1,1,'C',false);
    $this->pdf->Cell(136,5,Convertidor::numtoletras($importeTotal),0,0,'C',false);
    $this->pdf->Cell(28,5,'',0,0,'C',false);
    $this->pdf->Cell(32,5,'',0,1,'R',false);

    $this->pdf->Cell(0,10,'',0,1);//Espacio

    $this->pdf->Image('logo_left.png',10,137);
    $this->pdf->Image('logo_right.png',185,133);

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

    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->SetTextColor(0);
    $this->pdf->Cell(73,5,utf8_decode('RECIBO DE COMPRA'),0,0,'C');
    $this->pdf->Cell(60,5,utf8_decode(''),0,0,'C');
    $this->pdf->Cell(43,5,utf8_decode('RECIBO'),0,0,'R');
    $this->pdf->SetTextColor(255,0,0);
    $this->pdf->SetFont('Arial', 'B', 15);
    $this->pdf->Cell(30,5,($salidaProducto->folio_recibo <100) ? '000'.$salidaProducto->folio_recibo : '00'.$salidaProducto->folio_recibo,0,1,'C');

    $this->pdf->SetTextColor(0);
    $this->pdf->SetFillColor(234,234,234);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Fecha',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(28,5,$salidaProducto->fecha_venta->format('Y-m-d'),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Nivel',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(22,5,utf8_decode($grado->nombre),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(18,5,'Grupo',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(20,5,utf8_decode($grupo->nombre),1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(14,5,'Ciclo',1,0,'C',true);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->Cell(18,5,$ciclo->periodo,1,0,'C',false);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->Cell(20,5,'Matricula',1,0,'C',true);
    $this->pdf->Cell(30,5,$alumno->matricula,1,1,'C',false);

    $this->pdf->Cell(0,2,'',0,1);//Espacio


    $this->pdf->SetTextColor(0);
    $this->pdf->SetFont('Arial', '', 8);
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(28,4,'Alumno',1,0,'C',true);
    $this->pdf->Cell(75,4,utf8_decode($alumno->full_name),1,0,'L',false);
    $this->pdf->Cell(28,4,'Tutor',1,0,'C',true);
    $this->pdf->Cell(75,4,utf8_decode($tutor->full_name),1,1,'L',false);
    $this->pdf->Cell(28,4,'Direccion',1,0,'C',true);
    $this->pdf->Cell(178,4,utf8_decode($infoAlumno->direccion.' '.$infoAlumno->colonia),1,1,'L',false);

    $this->pdf->Cell(0,2,'',0,1,'',false);

    //Verde
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(10,5,'#',1,0,'C',true);
    $this->pdf->Cell(20,5,'Categoria',1,0,'C',true);
    $this->pdf->Cell(111,5,utf8_decode('Descripción del producto'),1,0,'C',true);
    $this->pdf->Cell(20,5,'Cantidad',1,0,'C',true);
    $this->pdf->Cell(20,5,'Prec. Unit.',1,0,'C',true);
    $this->pdf->Cell(25,5,'Importe',1,1,'C',true);

    $this->pdf->SetFillColor(234,234,234);

    $i=1;
    $importePorFila = 0;
    $importeTotal = 0;
    foreach ($productos as $producto){
      $fill = ($i%2) == 0 ? true : false;
      $importePorFila = $producto->cantidad * $producto->precio_unitario;
      $importeTotal = $importeTotal + $importePorFila;
      $this->pdf->Cell(10,5,$producto->numero_linea,'LR',0,'C',$fill);
      $this->pdf->Cell(20,5,utf8_decode($producto->nombre_categoria),'LR',0,'C',$fill);
      $this->pdf->Cell(111,5,utf8_decode($producto->nombre),'LR',0,'L',$fill);
      $this->pdf->Cell(20,5,$producto->cantidad,'LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'$ '.number_format($producto->precio_unitario,2,'.',','),'LR',0,'C',$fill);
      $this->pdf->Cell(25,5,'$ '.number_format($importePorFila,2,'.',','),'LR',1,'C',$fill);
      $i++;
    }

    for($y=$i; $y<=10; $y++){
      $fill = ($i%2) == 0 ? true : false;
      $this->pdf->Cell(10,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'L',$fill);
      $this->pdf->Cell(111,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(20,5,'','LR',0,'C',$fill);
      $this->pdf->Cell(25,5,'','LR',1,'R',$fill);
      $i++;
    }

    $this->pdf->SetFont('Arial', 'B', 8);
    //Color para el relleno de celdas: Verde Claro
    $this->pdf->SetFillColor(196,224,180);

    //Verde
    $this->pdf->SetFillColor(196,224,180);
    $this->pdf->Cell(141,5,'Importe con letras:','T',0,'C',false);
    $this->pdf->Cell(40,5,'Total',1,0,'C',true);
    $this->pdf->Cell(25,5,'$ '.number_format($importeTotal,2,'.',','),1,1,'C',false);
    $this->pdf->Cell(136,5,Convertidor::numtoletras($importeTotal),0,0,'C',false);
    $this->pdf->Cell(28,5,'',0,0,'C',false);
    $this->pdf->Cell(32,5,'',0,1,'R',false);
    
    $this->pdf->Output();
    exit;
  }
}
