<?php

namespace App\Http\Controllers\Impresion;

use App\Models\Alumno;
use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use App\Models\Config\Grupo;
use App\Models\InformacionAlumno;
use App\Models\InformacionTutor;
use App\Models\Inscripcion;
use App\Models\Tutor;

use App\Helpers\Convertidor;
use App\Http\Controllers\Controller;
use Codedge\Fpdf\Facades\Fpdf;

class HojaInscripcion extends Controller
{
  public function printPDF(Inscripcion $inscripcion)
  {
    $direccion = 'Calle Faisán # 147 entre Chablé y Retorno 3.';
    $direccion .= ' Chetumal, Q.Roo.';
    $direccion .= ' RFC: IMA-040824-R97';
    $direccion .= ' Tel. (983) 83 7 64 66';
    //Cell: ancho, alto, texto, border, ln, align, fill

    $alumno = Alumno::find($inscripcion->alumno_id);
    $ciclo = Ciclo::find($inscripcion->ciclo_id);
    $grado = Grado::find($inscripcion->grado_id);
    $grupo = Grupo::find($inscripcion->grupo_id);
    $infoAlumno = InformacionAlumno::find($inscripcion->infoalumno_id);
    $tutor = Tutor::find($infoAlumno->tutor_id);
    $infoTutor = InformacionTutor::where('infoalumno_id',$inscripcion->infoalumno_id)->first();

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

    Fpdf::SetFont('Arial', 'B', 9); //Arial, Bold, 9
    Fpdf::SetTextColor(0,0,0); //Color del texto: Negro
    Fpdf::SetFillColor(234,234,234); //Color de relleno: Gris claro

    Fpdf::cell(98,5,'',0,0);
    Fpdf::cell(49,5, utf8_decode('Matrícula'), 1,0,'L', true);
    Fpdf::SetFont('Arial', '', 9);
    Fpdf::cell(49,5,$alumno->matricula,1,1,'C'); //Salto de linea

    Fpdf::SetFont('Arial', 'B', 9);
    Fpdf::cell(98,5,'',0,0);
    Fpdf::cell(49,5, utf8_decode('Fecha de Inscripción'), 1,0,'L', true);
    Fpdf::SetFont('Arial', '', 9);
    Fpdf::cell(49,5,$inscripcion->fecha->format('d-m-Y'),1,1,'C'); //Salto de linea

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
    Fpdf::cell(49,5, utf8_decode('Ciclo Escolar'), 1,0,'L', true);
    Fpdf::SetFont('Arial', '', 9);
    Fpdf::cell(49,5,$ciclo->periodo,1,1,'C'); //Salto de linea

    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(0,3,'',0,1);//Espacio
    Fpdf::Cell(196,6,'FICHA DE INCRIPCION','TB',1,'C');
    Fpdf::Cell(0,3,'',0,1);//Espacio

    //Verde
    Fpdf::SetFillColor(197,224,180);
    Fpdf::Cell(196,6,'DATOS PERSONALES DEL ALUMNO',1,1,'C', true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(98,5,'Nombre(s)',1,0,'C',true);
    Fpdf::Cell(49,5,'Apellido Paterno',1,0,'C',true);
    Fpdf::Cell(49,5,'Apellido Materno',1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(98,5,$alumno->nombre1.' '.$alumno->nombre2,1,0,'C',true);
    Fpdf::Cell(49,5,$alumno->apellido1,1,0,'C',true);
    Fpdf::Cell(49,5,$alumno->apellido2,1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(48,5,'C.U.R.P',1,0,'C',true);
    Fpdf::Cell(50,5,'Fecha de Nacimiento',1,0,'C',true);
    Fpdf::Cell(49,5,'Edad',1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Género'),1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(48,5,$alumno->curp,1,0,'C',true);
    Fpdf::Cell(50,5,$alumno->fechanacimiento->format('d-m-Y'),1,0,'C',true);
    Fpdf::Cell(49,5,$alumno->fechanacimiento->diffInYears($inscripcion->fecha).utf8_decode(' años'),1,0,'C',true);
    Fpdf::Cell(49,5,$alumno->genero === 'H' ? 'Hombre' : 'Mujer',1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(105,5,utf8_decode('Dirección'),1,0,1,true);
    Fpdf::Cell(65,5,'Colonia',1,0,'C',true);
    Fpdf::Cell(26,5,utf8_decode('Código Postal'),1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(105,5,utf8_decode($infoAlumno->direccion),1,0,1,true);
    Fpdf::Cell(65,5,utf8_decode($infoAlumno->nombre_asentamiento),1,0,'C',true);
    Fpdf::Cell(26,5,$infoAlumno->codigo_postal,1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(65,5,utf8_decode('Delegación/Municipio'),1,0,'C',true);
    Fpdf::Cell(65,5,'Ciudad/Localidad',1,0,'C',true);
    Fpdf::Cell(66,5,'Estado',1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(65,5,utf8_decode($infoAlumno->delegacion),1,0,'C',true);
    Fpdf::Cell(65,5,utf8_decode($infoAlumno->localidad),1,0,'C',true);
    Fpdf::Cell(66,5,utf8_decode($infoAlumno->estado),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(49,5,utf8_decode('Teléfono de Casa'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Teléfono del Tutor'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Celular'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Otro'),1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(49,5,$infoAlumno->telefcasa.' '.utf8_decode($infoAlumno->referencia1),1,0,'C',true);
    Fpdf::Cell(49,5,$infoAlumno->teleftutor.' '.utf8_decode($infoAlumno->referencia2),1,0,'C',true);
    Fpdf::Cell(49,5,$infoAlumno->telefcelular.' '.utf8_decode($infoAlumno->referencia3),1,0,'C',true);
    Fpdf::Cell(49,5,$infoAlumno->telefotro.' '.utf8_decode($infoAlumno->referencia4),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(98,5,utf8_decode('Escuela'),1,0,1,true);
    Fpdf::Cell(98,5,utf8_decode('Lugar de Trabajo'),1,1,1,true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->escuela),1,0,1,true);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->lugartrabajo),1,1,1,true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(98,5,utf8_decode('Último Grado Escolar a Cursar'),1,0,1,true);
    Fpdf::Cell(98,5,utf8_decode('Correo eléctronico del alumno'),1,1,1,true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->ultimogrado),1,0,1,true);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->email),1,1,1,true);

    //Verde
    Fpdf::SetFillColor(197,224,180);
    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(196,6,'OTROS DATOS',1,1,'C', true);
    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(98,5,utf8_decode('¿Cómo te enteraste de la escuela?'),1,0,'C',true);
    Fpdf::Cell(98,5,utf8_decode('¿Por qué quieres estudiar inglés?'),1,1,'C',true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->pregunta1),1,0,'C',true);
    Fpdf::Cell(98,5,utf8_decode($infoAlumno->pregunta2),1,1,'C',true);

    //Verde
    Fpdf::SetFillColor(197,224,180);
    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(196,6,'DATOS DEL TUTOR',1,1,'C', true);
    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(98,5,'Nombre(s)',1,0,'C',true);
    Fpdf::Cell(49,5,'Apellido Paterno',1,0,'C',true);
    Fpdf::Cell(49,5,'Apellido Materno',1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(98,5,utf8_decode($tutor->nombre),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode($tutor->apellido1),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode($tutor->apellido2),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(105,5,utf8_decode('Dirección'),1,0,1,true);
    Fpdf::Cell(65,5,'Colonia',1,0,'C',true);
    Fpdf::Cell(26,5,utf8_decode('Código Postal'),1,1,'C',true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(105,5,utf8_decode($infoTutor->direccion),1,0,1,true);
    Fpdf::Cell(65,5,utf8_decode($infoTutor->nombre_asentamiento),1,0,'C',true);
    Fpdf::Cell(26,5,$infoTutor->codigo_postal,1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(65,5,utf8_decode('Delegación/Municipio'),1,0,'C',true);
    Fpdf::Cell(65,5,'Ciudad/Localidad',1,0,'C',true);
    Fpdf::Cell(66,5,'Estado',1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(65,5,utf8_decode($infoTutor->delegacion),1,0,'C',true);
    Fpdf::Cell(65,5,utf8_decode($infoTutor->localidad),1,0,'C',true);
    Fpdf::Cell(66,5,utf8_decode($infoTutor->estado),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(49,5,utf8_decode('Teléfono de Casa'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Teléfono del Trabajo'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Celular'),1,0,'C',true);
    Fpdf::Cell(49,5,utf8_decode('Otro'),1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(49,5,$infoTutor->telefcasa.' '.utf8_decode($infoTutor->referencia1),1,0,'C',true);
    Fpdf::Cell(49,5,$infoTutor->teleftrabajo.' '.utf8_decode($infoTutor->referencia2),1,0,'C',true);
    Fpdf::Cell(49,5,$infoTutor->telefcelular.' '.utf8_decode($infoTutor->referencia3),1,0,'C',true);
    Fpdf::Cell(49,5,$infoTutor->telefotro.' '.utf8_decode($infoTutor->referencia4),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(196,5,utf8_decode('Nombre del lugar de trabajo'),1,1,1,true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(196,5,utf8_decode($infoTutor->adicional_trabajo),1,1,1,true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(105,5,utf8_decode('Dirección del lugar de trabajo'),1,0,1,true);
    Fpdf::Cell(65,5,'Colonia',1,0,'C',true);
    Fpdf::Cell(26,5,utf8_decode('Código Postal'),1,1,'C',true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(105,5,utf8_decode($infoTutor->adicional_direccion),1,0,1,true);
    Fpdf::Cell(65,5,utf8_decode($infoTutor->adicional_nombreasentamiento),1,0,'C',true);
    Fpdf::Cell(26,5,$infoTutor->adicional_codpost,1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(65,5,utf8_decode('Delegación/Municipio'),1,0,'C',true);
    Fpdf::Cell(65,5,'Ciudad/Localidad',1,0,'C',true);
    Fpdf::Cell(66,5,'Estado',1,1,'C',true);

    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);

    Fpdf::Cell(65,5,utf8_decode($infoTutor->adicional_delegacion),1,0,'C',true);
    Fpdf::Cell(65,5,utf8_decode($infoTutor->adicional_localidad),1,0,'C',true);
    Fpdf::Cell(66,5,utf8_decode($infoTutor->adicional_estado),1,1,'C',true);

    //Gris Claro
    Fpdf::SetFillColor(234,234,234);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(196,5,utf8_decode('Correo eléctronico del tutor'),1,1,'C',true);
    //Blanco
    Fpdf::SetFillColor(255,255,255);
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::Cell(196,5,utf8_decode($infoTutor->email),1,1,'C',true);

    Fpdf::cell(0,16,'',0,1);
    Fpdf::SetFont('Arial', 'B', 8);
    Fpdf::Cell(0,6,utf8_decode('Se entrego Tarjetas de Pago, Reglamento, Fechas de entrega de Boletas y Dias de Suspensión'),0,1,'C');



    Fpdf::Output();
    exit;
  }
}
