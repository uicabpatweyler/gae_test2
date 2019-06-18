<?php

use App\Models\Config\MesDePago;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MesesDePagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $meses = array('Agosto','Septiembre','Octubre','Noviembre','Diciembre',
        'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio');
      $d1 = Carbon::create('2018',8,1);
        //$begin->addMonth()

      for($y=0; $y<12; $y++){

        $d2 = $d1->copy()->addDays(9);
        $d3 = $d1->copy()->addDays(10);
        $d4 = $d1->copy()->addMonth();
        MesDePago::create([
          'cuota_id' => 2,
          'orden'    => $y + 1,
          'mes'      => $meses[$y],
          'fecha1'   => $d1,
          'fecha2'   => $d2,
          'fecha3'   => $d3,
          'fecha4'   => $d4->subDay(),
          'recargo'   =>  5,
          'descuento' => 0
        ]);
        $d1 = $d4->addDay();
      }
    }
}
