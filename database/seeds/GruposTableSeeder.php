<?php

use App\Models\Config\Grupo;
use Illuminate\Database\Seeder;

class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escuela1 = 1;
        $escuela2 = 2;
        $escuela3 = 3;

        $ciclo1 = 20;
        $ciclo2 = 19;

        $grado1 = 1;
        $grado2 = 2;
        $grado3 = 3;

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado1,
            'nombre'     => 'P01A',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado1,
            'nombre'     => 'P01B',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado2,
            'nombre'     => 'I01A',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado2,
            'nombre'     => 'I01B',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado3,
            'nombre'     => 'A01A',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => $escuela1,
            'ciclo_id'   => $ciclo1,
            'grado_id'   => $grado3,
            'nombre'     => 'A01B',
            'cupoalumnos' => 30,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);




    }
}
