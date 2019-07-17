<?php

namespace App\ModelsPdf;

use Codedge\Fpdf\Fpdf\Fpdf;

class PagosColegiaturaPorDia extends Fpdf
{
  public function Header()
  {
    $this->SetLineWidth(.4);
    $this->SetDrawColor(55,86,35);
    $this->SetFont('Arial', 'B', 8);
    $this->Cell(0,6,utf8_decode('ACADEMIA DE INGLÉS: IRLANDA'),'TB',1,'C');
  }

  public function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
  }
}
