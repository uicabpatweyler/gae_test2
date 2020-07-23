<?php

namespace App\Http\Controllers\Impresion;

use App\Models\Alumno;
use App\Models\Inscripcion;

use App\Models\PagoColegiatura;
use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistorialDePagos extends Controller
{
    protected $pdf;
    public function __construct(\App\ModelsPdf\HistorialDePagos $pdf)
    {
        $this->pdf = $pdf;
    }

    public function printPdf($inscripcionId)
    {

        $info = Inscripcion::query()
            ->where('inscripciones.id', $inscripcionId)
            ->join('ciclos', 'inscripciones.ciclo_id','=', 'ciclos.id')
            ->join('grupos', 'inscripciones.grupo_id', '=', 'grupos.id')
            ->join('informacion_alumnos', 'inscripciones.infoalumno_id','=', 'informacion_alumnos.id')
            ->join('pago_inscripciones', 'inscripciones.pago_id','=','pago_inscripciones.id')
            ->select('inscripciones.alumno_id')
            ->addselect('ciclos.id as ciclo_id','ciclos.periodo', 'grupos.id as grupo_id', 'grupos.nombre as grupo')
            ->addSelect('informacion_alumnos.tutor_id','informacion_alumnos.nombre_vialidad', 'informacion_alumnos.exterior')
            ->addSelect('informacion_alumnos.entre_calles', 'informacion_alumnos.nombre_asentamiento')
            ->addSelect('pago_inscripciones.serie_recibo', 'pago_inscripciones.folio_recibo')
            ->addSelect('pago_inscripciones.importe_cuota','pago_inscripciones.porcentaje_descuento')
            ->addSelect('pago_inscripciones.descuento_pesos', 'pago_inscripciones.fecha')
            ->first();
        $alumno = Alumno::find($info->alumno_id);
        $tutor = Tutor::find($info->tutor_id);

        $this->pdf->SetMargins(5,5,5);
        $this->pdf->SetAutoPageBreak(true,20);
        $this->pdf->AddPage('P','Letter');
        $this->pdf->AliasNbPages();

        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0);
        $this->pdf->SetLineWidth(.2);
        $this->pdf->SetDrawColor(0,128,0);

        $this->pdf->Cell(0,8,'HISTORIAL DE PAGOS','B',1,'C',false);
        $this->pdf->Cell(0,1,'',0,1,'',false);

        $this->espacio(1);
        $this->reset();
        //206
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetFillColor(196,224,180);

        $this->pdf->Cell(30,5,'Matricula',1, 0, 'C',true);
        $this->pdf->Cell(60,5,utf8_decode($alumno->matricula), 1,0,'C',false);
        $this->pdf->Cell(30,5,'Alumno',1, 0, 'C',true);
        $this->pdf->Cell(86,5,utf8_decode($alumno->full_name), 1,1,'C',false);

        $this->pdf->Cell(30,5,'Grupo',1, 0, 'C',true);
        $this->pdf->Cell(60,5,utf8_decode($info->grupo), 1,0,'C',false);
        $this->pdf->Cell(30,5,'Ciclo',1, 0, 'C',true);
        $this->pdf->Cell(86,5,$info->periodo, 1,1,'C',false);

        $this->pdf->Cell(30,5,'Tutor',1, 0, 'C',true);
        $this->pdf->Cell(176,5,utf8_decode($tutor->nombre.' '.$tutor->apellido1.' '.$tutor->apellido2), 1,1,'L',false);

        $this->pdf->Cell(30,5,utf8_decode('Dirección'),1, 0, 'C',true);
        $this->pdf->Cell(176,5,utf8_decode($info->nombre_vialidad.' '.$info->exterior.' '.$info->entre_calles.' '.$info->nombre_asentamiento), 1,1,'L',false);

        $this->espacio(5);
        $this->reset();

        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->SetTextColor(255,255,255);
        $this->pdf->SetFillColor(57,107,54);

        $this->pdf->Cell(30,5,utf8_decode('Concepto'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Folio'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Fecha'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Mes'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Importe'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Descuento'),0,0,'C', true);
        $this->pdf->Cell(25,5,utf8_decode('Recargo'),0,0,'C', true);
        $this->pdf->Cell(26,5,utf8_decode('Importe'),0,1,'C', true);

        $this->reset();
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->SetFillColor(230,242,230);

        $total = 0;
        $total = $total + ( $info->importe_cuota - $info->descuento_pesos );

        $this->pdf->Cell(30,5,utf8_decode('Inscripcion'),0,0,'C', false);
        $this->pdf->Cell(25,5,utf8_decode($info->serie_recibo.'-'.$info->folio_recibo),0,0,'C', false);
        $this->pdf->Cell(25,5,$info->fecha->format('d-m-Y'),0,0,'C', false);
        $this->pdf->Cell(25,5,utf8_decode('N/A'),0,0,'C', false);
        $this->pdf->Cell(25,5,'$ '.number_format($info->importe_cuota,2,'.',','),0,0,'C', false);
        $this->pdf->Cell(25,5,'$ '.number_format($info->descuento_pesos,2,'.',','),0,0,'C', false);
        $this->pdf->Cell(25,5,'$ '.number_format(0,2,'.',','),0,0,'C', false);
        $this->pdf->Cell(26,5,'$ '.number_format($info->importe_cuota - $info->descuento_pesos,2,'.',','),0,1,'C', false);

        $pay = PagoColegiatura::query()
            ->where('ciclo_id', $info->ciclo_id)
            ->where('alumno_id', $info->alumno_id)
            ->where('pago_cancelado', '=', 0)
            ->orderBy('folio_recibo','asc')
            ->get();

        $loop = 1;

        foreach ($pay as $row)
        {
            foreach ($row->details as $detail)
            {
                $fill = $loop % 2 ? true : false;
                $this->pdf->Cell(30,5,utf8_decode('Colegiatura'),0,0,'C', $fill);
                $this->pdf->Cell(25,5,utf8_decode($row->serie_recibo.'-'.$row->folio_recibo),0,0,'C', $fill);
                $this->pdf->Cell(25,5,$row->fecha_pago->format('d-m-Y'),0,0,'C', $fill);
                $this->pdf->Cell(25,5,utf8_decode($detail->nombre_mes),0,0,'C', $fill);
                $this->pdf->Cell(25,5,'$ '.number_format($detail->importe_colegiatura,2,'.',','),0,0,'C', $fill);

                $importe = ( $detail->importe_colegiatura - $detail->descuento_pesos ) + $detail->recargo_pesos;

                if($detail->porcentaje_descuento!=0)
                {
                    $this->pdf->Cell(25,5,'$ '.number_format($detail->descuento_pesos,2,'.',',').' ('.$detail->porcentaje_descuento.'%)',0,0,'C', $fill);
                }
                else
                {
                    $this->pdf->Cell(25,5,'$ '.number_format(0,2,'.',','),0,0,'C', $fill);
                }

                if($detail->porcentaje_recargo!=0)
                {
                    $this->pdf->Cell(25,5,'$ '.number_format($detail->recargo_pesos,2,'.',',').' ('.$detail->porcentaje_recargo.'%)',0,0,'C', $fill);
                }
                else
                {
                    $this->pdf->Cell(25,5,'$ '.number_format(0,2,'.',','),0,0,'C', $fill);
                }

                $this->pdf->Cell(26,5,'$ '.number_format($importe,2,'.',','),0,1,'C', $fill);

                $loop++;
                $total = $total + $importe;
            }
        }

        $this->pdf->SetLineWidth(.8);
        $this->pdf->SetDrawColor(57,107,54);
        $this->pdf->Cell(0,1,'','T',1,'C');

        $this->reset();

        $this->pdf->Cell(30,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);
        $this->pdf->Cell(25,5,'',0,0,'C', false);

        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->SetTextColor(0,0,0);

        $this->pdf->Cell(26,5,'$ '.number_format($total,2,'.',','),0,1,'C', false);

        $this->pdf->Output();
        exit;

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
