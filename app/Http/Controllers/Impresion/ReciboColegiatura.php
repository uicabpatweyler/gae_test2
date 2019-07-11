<?php

namespace App\Http\Controllers\Impresion;

use App\Models\PagoColegiatura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReciboColegiatura extends Controller
{
  public function printPDF(PagoColegiatura $pagoColegiatura){
    return $pagoColegiatura;
  }
}
