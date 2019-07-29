<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Models\Config\Categoria;
use App\Models\Config\Ciclo;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class Kardex extends Controller
{
  protected $pdf;

  public function __construct(\App\ModelsPdf\Kardex $pdf)
  {
    $this->pdf = $pdf;
  }

  public function printPDF($escuela,$ciclo,$categoria){

    $_ciclo = Ciclo::find($ciclo);
    $_categoria = Categoria::find($categoria);

    $this->pdf->SetMargins('5','5','5');
    $this->pdf->SetAutoPageBreak(true,10);
    $this->pdf->AddPage('P','Letter');
    $this->pdf->AliasNbPages();

    $this->pdf->SetFont('Arial', 'B', 10);
    $this->pdf->SetTextColor(0);
    $this->pdf->SetLineWidth(.2);
    $this->pdf->SetDrawColor(0);
    $this->pdf->SetFillColor(255,255,255);

    $this->pdf->Cell(103,8,'Kardex de productos del ciclo: '.$_ciclo->periodo,'B',0,'C',false);
    $this->pdf->Cell(103,8,'Categoria: '.$_categoria->nombre,'B',1,'C',false);

    $this->pdf->Cell(0,5,'',0,1,'',false);

    $this->pdf->SetFont('Arial', '', 9);

    $firstsParents = Categoria::where('parent_id', $categoria)->get();

    foreach ($firstsParents as $firstsParent) {

      $secondsParents = Categoria::where('parent_id',$firstsParent->id)->get();

      $i=1;
      foreach ($secondsParents as $secondsParent) {

        $this->pdf->SetTextColor(0);
        $this->pdf->SetFillColor(234,234,234);
        $this->pdf->SetFont('Arial', 'B', 9);

        $this->pdf->Cell(8,5,'',1,0,'',true);
        $this->pdf->Cell(86,5,$secondsParent->nombre,1,0,'C',true);
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(24,5,'Precio Vta.',1,0,'C',true);
        $this->pdf->Cell(20,5,'Inicial',1,0,'C',true);
        $this->pdf->Cell(20,5,'Entradas',1,0,'C',true);
        $this->pdf->Cell(20,5,'Salidas',1,0,'C',true);
        $this->pdf->Cell(20,5,'Existencia',1,1,'C',true);

        $this->pdf->SetTextColor(0);
        $this->pdf->SetFillColor(255,255,255);
        $this->pdf->SetFont('Arial', '', 8);

        $productos = Producto::where('escuela_id', $escuela)
          ->where('ciclo_id', $ciclo)
          ->where('clasificacion1_id', $secondsParent->id)
          ->get();

        foreach ($productos as $producto) {
          $this->pdf->Cell(8,5,$i++,1,0,'C',false);
          $this->pdf->Cell(86,5,utf8_decode($producto->nombre),1,0,'',false);
          $this->pdf->Cell(24,5,'$ '.number_format($producto->precio_venta,2,'.',','),1,0,'C',false);
          $this->pdf->Cell(20,5,$this->kardexProducto($escuela,$ciclo,$producto->id,1),1,0,'C',false);
          $this->pdf->Cell(20,5,$this->kardexProducto($escuela,$ciclo,$producto->id,2),1,0,'C',false);
          $this->pdf->Cell(20,5,$this->kardexProducto($escuela,$ciclo,$producto->id,3),1,0,'C',false);
          $this->pdf->Cell(20,5,$this->kardexProducto($escuela,$ciclo,$producto->id,4),1,1,'C',false);
        }

      }
      $this->pdf->Cell(0,5,'',0,1,'',false);
    }


    $this->pdf->Output();

    exit;
  }

  private function kardexProducto($escuela, $ciclo, $producto,$column){
    $row = DB::table('kardex')
      ->where([
        ['escuela_id', '=', $escuela],
        ['ciclo_id', '=', $ciclo],
        ['producto_id', '=', $producto]
      ])
      ->first();
    if($column===1){
      return $row->inicial;
    }
    if($column===2){
      return $row->entradas;
    }
    if($column===3){
      return $row->salidas;
    }
    if($column===4){
      return $row->existencia;
    }
  }
}
