<?php

namespace App\ModelsPdf;

use Codedge\Fpdf\Fpdf\Fpdf;

class PagosInscripcionPorDia extends Fpdf
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
    $this->SetFont('Arial','',8);
    $this->SetLineWidth(.2);
    $this->SetDrawColor(0);
    $this->Cell(0,2,'','',1,'',false);

    $this->SetFont('Arial', '', 7);
    $this->Cell(62,4,utf8_decode('María del Carmén Kantun Cupul'),'T',0,'C');
    $this->Cell(10,4,'',0,0);
    $this->Cell(62,4,utf8_decode('Gaspar Felipe Sandoval Gómez'),'T',0,'C');
    $this->Cell(10,4,'',0,0);
    $this->Cell(62,4,utf8_decode('Mtra. Flor Patrón'),'T',1,'C');
    $this->Cell(62,3,'Encargada de Caja',0,0,'C');
    $this->Cell(10,3,'',0,0);
    $this->Cell(62,3,'Control Escolar',0,0,'C');
    $this->Cell(10,3,'',0,0);
    $this->Cell(62,3,'Directora',0,1,'C');
  }
}

