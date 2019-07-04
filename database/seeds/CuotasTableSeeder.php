<?php

use App\Models\Config\Cuota;
use Illuminate\Database\Seeder;

class CuotasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Cuota::create([
          'escuela_id' => 1,
          'ciclo_id'   => 1,
          'nombre' => 'Cuota de Inscripción: Ciclo 2018-2019',
          'tipo' => 1,
          'cantidad' => 450
      ]);

      Cuota::create([
        'escuela_id' => 1,
        'ciclo_id'   => 1,
        'nombre' => 'Cuota de Colegiatura: Ciclo 2018-2019',
        'tipo' => 2,
        'cantidad' => 1000
      ]);

      Cuota::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'nombre' => 'Cuota de Inscripción: Ciclo 2019-2020',
        'tipo' => 1,
        'cantidad' => 450
      ]);

      Cuota::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'nombre' => 'Cuota de Colegiatura: Ciclo 2018-2019',
        'tipo' => 2,
        'cantidad' => 1050
      ]);
    }
}
