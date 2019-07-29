<?php

namespace App\ModelsPdf;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class Kardex extends Fpdf
{
  public function Header()
  {
    $direccion = 'Calle Faisán # 147 entre Chablé y Retorno 3.';
    $direccion .= ' Chetumal, Q.Roo.';
    $direccion .= ' RFC: IMA-040824-R97';
    $direccion .= ' Tel. (983) 83 7 64 66';

    $this->Image('logo_left.png',10,15);
    $this->Image('logo_right.png',185,11);

    /*Empieza encabezado*/
    $this->SetFont('Times','BI', 14);
    $this->SetTextColor(0,128,0);

    $this->Cell(90,5,'IRLANDA Academy of English',0,0,'L');
    $this->Cell(16,5,'',0,0);
    $this->Cell(90,5,utf8_decode('Academia de Inglés IRLANDA'),0,1,'R');

    $this->SetFont('Arial', '', 8);
    $this->SetLineWidth(.8);
    $this->SetDrawColor(0,128,0);

    $this->Cell(0,5,utf8_decode($direccion),0,1,'C');
    $this->Cell(0,5,utf8_decode('INCORPORACIÓN A LA SEQ. C.C.T. 23PBT003'),0,1,'C');
    $this->Cell(0,5,utf8_decode('NÚMERO DE ACUERDO DE INCORPORACIÓN: ICAT17001CT'),0,1,'C');
    $this->Cell(0,5,utf8_decode('DE 20 DE FEBRERO DEL 2017'),'B',1,'C');
    /*Termina encabezado*/
  }

  public function Footer()
  {
    $this->SetTextColor(0);
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,3,utf8_decode('Página ').$this->PageNo().' de {nb}',0,1,'C');
    $this->Cell(0,3,utf8_decode('Fecha y Hora de Impresión: '.Carbon::now()->format('d-m-Y, h:m:s a')),0,1,'C', false);
  }
}
