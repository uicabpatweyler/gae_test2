<?php

use App\Models\Entrada;
use Illuminate\Database\Seeder;

class EntradasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Ciclo 2018-2019
      Entrada::create([
        'escuela_id' => 1,
        'ciclo_id'   => 1,
        'serie'      => '',
        'folio'      => '1',
        'tipo'       => '1',
        'referencia' => 'entrada de libros para el ciclo 2018-2019 (inventario inicial)',
        'fecha'      => '2018-07-26'
      ]);
      Entrada::create([
        'escuela_id' => 1,
        'ciclo_id'   => 1,
        'serie'      => '',
        'folio'      => '2',
        'tipo'       => '1',
        'referencia'     => 'entrada de playeras para el ciclo 2018-2019 (inventario inicial)',
        'fecha'      => '2018-07-26'
      ]);
      //Ciclo 2019-2020
      Entrada::create([
        'escuela_id' => 1,
        'ciclo_id'   => 1,
        'serie'      => '',
        'folio'      => '3',
        'tipo'       => '2',
        'referencia'     => 'entrada de libros para el ciclo 2019-2020',
        'fecha'      => '2019-07-26'
      ]);
      Entrada::create([
        'escuela_id' => 1,
        'ciclo_id'   => 1,
        'serie'      => '',
        'folio'      => '4',
        'tipo'       => '2',
        'referencia'     => 'entrada de playeras para el ciclo 2019-2020',
        'fecha'      => '2019-07-26'
      ]);
    }
}
