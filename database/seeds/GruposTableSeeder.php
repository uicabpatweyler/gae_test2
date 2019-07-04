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
      /*Ciclo 2018-2019*/
        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 1,
            'nombre'     => 'P01A',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 1,
            'nombre'     => 'P02A',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 1,
            'nombre'     => 'P02B',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 1,
            'nombre'     => 'P03A',
            'cupoalumnos' => 27,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 1,
            'nombre'     => 'P03B',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i001a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i001b',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i002a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i002b',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i003a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 3,
            'nombre'     => 'a003a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 3,
            'nombre'     => 'a002a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 3,
            'nombre'     => 'a001a',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);

        Grupo::create([
            'escuela_id' => 1,
            'ciclo_id'   => 1,
            'grado_id'   => 2,
            'nombre'     => 'i003b',
            'cupoalumnos' => 25,
            'cuotainscripcion_id' => 0,
            'cuotacolegiatura_id' => 0
        ]);
        /*Ciclo 2018-2019*/

      /*Ciclo 2019-2020*/
      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 1,
        'nombre'     => 'P001A',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 1,
        'nombre'     => 'P002A',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 1,
        'nombre'     => 'P002B',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 1,
        'nombre'     => 'P003A',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 1,
        'nombre'     => 'P003b',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 2,
        'nombre'     => 'i001a',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 2,
        'nombre'     => 'i001b',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 2,
        'nombre'     => 'i002a',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 2,
        'nombre'     => 'i002b',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 2,
        'nombre'     => 'i003a',
        'cupoalumnos' => 30,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 3,
        'nombre'     => 'a001a',
        'cupoalumnos' => 25,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 3,
        'nombre'     => 'a002a',
        'cupoalumnos' => 15,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);

      Grupo::create([
        'escuela_id' => 1,
        'ciclo_id'   => 2,
        'grado_id'   => 3,
        'nombre'     => 'a003a',
        'cupoalumnos' => 17,
        'cuotainscripcion_id' => 0,
        'cuotacolegiatura_id' => 0
      ]);
      /*Ciclo 2019-2020*/
    }
}
