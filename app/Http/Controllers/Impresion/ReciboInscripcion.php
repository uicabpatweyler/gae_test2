<?php

namespace App\Http\Controllers\Impresion;

use App\Helpers\Convertidor;
use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\InformacionAlumno;
use App\Models\Inscripcion;
use App\Models\PagoInscripcion;
use App\Models\Tutor;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReciboInscripcion extends Controller
{
    public function printPDF(PagoInscripcion $pagoInscripcion, Inscripcion $inscripcion){
      $direccion = 'Calle Faisán # 147 entre Chablé y Retorno 3.';
      $direccion .= ' Chetumal, Q.Roo.';
      $direccion .= ' RFC: IMA-040824-R97';
      $direccion .= ' Tel. (983) 83 7 64 66';

      $grado = Grado::find($pagoInscripcion->grado_id);
      $grupo = Grupo::find($pagoInscripcion->grupo_id);
      $alumno = Alumno::find($pagoInscripcion->alumno_id);
      $ciclo = Ciclo::find($pagoInscripcion->ciclo_id);
      $infoAlumno = InformacionAlumno::find($inscripcion->infoalumno_id);
      $tutor = Tutor::find($infoAlumno->tutor_id);


      Fpdf::AddPage();

      /*Inicia Logo Encabezado*/
      Fpdf::Image('logo_left.png',10,20);
      Fpdf::Image('logo_right.png',185,16);
      Fpdf::SetFont('Times', 'BI', 14);
      Fpdf::SetTextColor(0,128,0);
      Fpdf::Cell(90,5,'IRLANDA Academy of English',0,0,'L');
      Fpdf::Cell(16,5,'',0,0);
      Fpdf::Cell(90,5,utf8_decode('Academia de Inglés IRLANDA'),0,1,'R');
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode($direccion),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('INCORPORACIÓN A LA SEQ             C.C.T. 23PBT003'),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('NÚMERO DE ACUERDO DE INCORPORACIÓN: ICAT17001CT '),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('DE 20 DE FEBRERO DEL 2017'),0,0,'C');
      Fpdf::Cell(38,5,'',0,1); //Salto de linea
      /*Termina Logo Encabezado*/

      Fpdf::cell(196,3,'',0,1); //Espacio

      Fpdf::SetFont('Arial', '', 10);
      Fpdf::SetTextColor(0,0,0);
      Fpdf::SetFillColor(255,255,255);
      Fpdf::Cell(98,5,utf8_decode('RFC: IMA-040824-R97'),0,0,1,true);
      Fpdf::Cell(98,5,utf8_decode('ESTE COMPROBANTE NO ES DEDUCIBLE DE I.S.R'),0,1,'R',true);

      Fpdf::SetFont('Arial', 'B', 9); //Arial, Bold, 9
      Fpdf::SetTextColor(0,0,0); //Color del texto: Negro
      Fpdf::SetFillColor(196,224,180); //Color de relleno: Verde claro

      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Recibo'), 1,0,'L', true);
      Fpdf::SetFont('Arial', 'B', 10);
      Fpdf::SetTextColor(255,0,0);
      Fpdf::cell(49,5,$pagoInscripcion->serie_recibo.'-'.$pagoInscripcion->folio_recibo,1,1,'C'); //Salto de linea

      Fpdf::SetTextColor(0,0,0);
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Fecha'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$pagoInscripcion->fecha->format('d-m-Y'),1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Nivel'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$grado->nombre,1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Grupo'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$grupo->nombre,1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Matrícula'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$alumno->matricula,1,1,'C'); //Salto de linea

      Fpdf::cell(0,2,'',0,1);

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(196,5,'RECIBIMOS DE:', 0,1,'C');
      Fpdf::Cell(0,3,'',0,1);//Espacio

      //Nombre del alumno
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,'Alumno',1,0,'C',true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(70,5,utf8_decode($alumno->full_name) ,1,0,'L',false);
      Fpdf::Cell(28,5,'Tutor',1,0,'C',true);
      Fpdf::Cell(70,5,utf8_decode($tutor->full_name) ,1,1,'L',false);

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,utf8_decode('Dirección'),1,0,'C',true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(168,5,utf8_decode($infoAlumno->direccion) ,1,1,'L',false);
      Fpdf::Cell(28,5,'',0,0,'C',false);
      Fpdf::Cell(168,5,utf8_decode($infoAlumno->delegacion.', '.$infoAlumno->localidad.', '.$infoAlumno->estado),1,1,'L',false);

      Fpdf::Cell(0,5,'',0,1);//Espacio
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,'Cantidad',1,0,'C',true);
      Fpdf::Cell(133,5,'Concepto',1,0,'C',true);
      Fpdf::Cell(35,5,'Importe',1,1,'C',true);

      //Blanco

      Fpdf::SetFont('Arial', '', 10);
      Fpdf::Cell(28,5,1,'LR',0,'C');
      Fpdf::Cell(133,5,utf8_decode('Cuota de Inscripción del Ciclo Escolar: ').$ciclo->periodo,'R',0,'C');
      Fpdf::Cell(35,5,'$ '.number_format($pagoInscripcion->importe_cuota,2,'.',','),'R',1,'C');

      for($i=1;$i<=2;$i++){
        Fpdf::Cell(28,5,'','LR',0,'C');
        Fpdf::Cell(133,5,'','R',0,'C');
        Fpdf::Cell(35,5,'','R',1,'C');
      }

      //Blanco
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(116,7,'Importe con letras:','T',0,'C');
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(45, 7, 'Total:',1,0,'C',true);
      Fpdf::Cell(35, 7,'$ '.number_format($pagoInscripcion->importe_cuota,2,'.',','),1,1,'C',false);

      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(116,7,Convertidor::numtoletras($pagoInscripcion->importe_cuota),0,1,'C');

      Fpdf::Cell(0,12,'',0,1,'C',false); //Espacio

      /*Inicia Logo Encabezado*/
      Fpdf::Image('logo_left.png',10,153);
      Fpdf::Image('logo_right.png',185,150);
      Fpdf::SetFont('Times', 'BI', 14);
      Fpdf::SetTextColor(0,128,0);
      Fpdf::Cell(90,5,'IRLANDA Academy of English',0,0,'L');
      Fpdf::Cell(16,5,'',0,0);
      Fpdf::Cell(90,5,utf8_decode('Academia de Inglés IRLANDA'),0,1,'R');
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode($direccion),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('INCORPORACIÓN A LA SEQ             C.C.T. 23PBT003'),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('NÚMERO DE ACUERDO DE INCORPORACIÓN: ICAT17001CT '),0,0,'C');
      Fpdf::Cell(38,5,'',0,1);
      Fpdf::SetFont('Arial', '', 8);
      Fpdf::Cell(38,5,'',0,0);
      Fpdf::Cell(120,5,utf8_decode('DE 20 DE FEBRERO DEL 2017'),0,0,'C');
      Fpdf::Cell(38,5,'',0,1); //Salto de linea
      /*Termina Logo Encabezado*/

      Fpdf::cell(196,3,'',0,1); //Espacio

      Fpdf::SetFont('Arial', '', 10);
      Fpdf::SetTextColor(0,0,0);
      Fpdf::SetFillColor(255,255,255);
      Fpdf::Cell(98,5,utf8_decode('RFC: IMA-040824-R97'),0,0,1,true);
      Fpdf::Cell(98,5,utf8_decode('ESTE COMPROBANTE NO ES DEDUCIBLE DE I.S.R'),0,1,'R',true);

      Fpdf::SetFont('Arial', 'B', 9); //Arial, Bold, 9
      Fpdf::SetTextColor(0,0,0); //Color del texto: Negro
      Fpdf::SetFillColor(196,224,180); //Color de relleno: Verde claro

      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Recibo'), 1,0,'L', true);
      Fpdf::SetFont('Arial', 'B', 10);
      Fpdf::SetTextColor(255,0,0);
      Fpdf::cell(49,5,$pagoInscripcion->serie_recibo.'-'.$pagoInscripcion->folio_recibo,1,1,'C'); //Salto de linea

      Fpdf::SetTextColor(0,0,0);
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Fecha'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$pagoInscripcion->fecha->format('d-m-Y'),1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Nivel'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$grado->nombre,1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Grupo'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$grupo->nombre,1,1,'C'); //Salto de linea

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(98,5,'',0,0);
      Fpdf::cell(49,5, utf8_decode('Matrícula'), 1,0,'L', true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::cell(49,5,$alumno->matricula,1,1,'C'); //Salto de linea

      Fpdf::cell(0,2,'',0,1);

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::cell(196,5,'RECIBIMOS DE:', 0,1,'C');
      Fpdf::Cell(0,3,'',0,1);//Espacio

      //Nombre del alumno
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,'Alumno',1,0,'C',true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(70,5,utf8_decode($alumno->full_name) ,1,0,'L',false);
      Fpdf::Cell(28,5,'Tutor',1,0,'C',true);
      Fpdf::Cell(70,5,utf8_decode($tutor->full_name) ,1,1,'L',false);

      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,utf8_decode('Dirección'),1,0,'C',true);
      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(168,5,utf8_decode($infoAlumno->direccion) ,1,1,'L',false);
      Fpdf::Cell(28,5,'',0,0,'C',false);
      Fpdf::Cell(168,5,utf8_decode($infoAlumno->delegacion.', '.$infoAlumno->localidad.', '.$infoAlumno->estado),1,1,'L',false);

      Fpdf::Cell(0,5,'',0,1);//Espacio
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(28,5,'Cantidad',1,0,'C',true);
      Fpdf::Cell(133,5,'Concepto',1,0,'C',true);
      Fpdf::Cell(35,5,'Importe',1,1,'C',true);

      //Blanco

      Fpdf::SetFont('Arial', '', 10);
      Fpdf::Cell(28,5,1,'LR',0,'C');
      Fpdf::Cell(133,5,utf8_decode('Cuota de Inscripción del Ciclo Escolar: ').$ciclo->periodo,'R',0,'C');
      Fpdf::Cell(35,5,'$ '.number_format($pagoInscripcion->importe_cuota,2,'.',','),'R',1,'C');

      for($i=1;$i<=2;$i++){
        Fpdf::Cell(28,5,'','LR',0,'C');
        Fpdf::Cell(133,5,'','R',0,'C');
        Fpdf::Cell(35,5,'','R',1,'C');
      }

      //Blanco
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(116,7,'Importe con letras:','T',0,'C');
      Fpdf::SetFont('Arial', 'B', 9);
      Fpdf::Cell(45, 7, 'Total:',1,0,'C',true);
      Fpdf::Cell(35, 7,'$ '.number_format($pagoInscripcion->importe_cuota,2,'.',','),1,1,'C',false);

      Fpdf::SetFont('Arial', '', 9);
      Fpdf::Cell(116,7,Convertidor::numtoletras($pagoInscripcion->importe_cuota),0,1,'C');

      Fpdf::Output();
      exit;
    }
}
