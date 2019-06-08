<?php

use App\Models\Config\Grado;
use Illuminate\Database\Seeder;

class GradosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escuela1=1;
        $ciclo1=19;

        $escuela2=2;
        $ciclo2=22;


        Grado::create([
            'escuela_id'  => $escuela1,
            'ciclo_id'    => $ciclo1,
            'nombre'      => 'Principiante',
            'abreviacion' => 'P'
        ]);

        Grado::create([
            'escuela_id'  => $escuela1,
            'ciclo_id'    => $ciclo1,
            'nombre'      => 'Intermedio',
            'abreviacion' => 'I'
        ]);

        Grado::create([
            'escuela_id'  => $escuela1,
            'ciclo_id'    => $ciclo1,
            'nombre'      => 'Avanzado',
            'abreviacion' => 'A'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Primero',
            'abreviacion' => '1ero.'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Segundo',
            'abreviacion' => '2do.'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Tercero',
            'abreviacion' => '3ero.'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Cuarto',
            'abreviacion' => '4to.'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Quinto',
            'abreviacion' => '5to.'
        ]);

        Grado::create([
            'escuela_id'  => $escuela2,
            'ciclo_id'    => $ciclo2,
            'nombre'      => 'Sexto',
            'abreviacion' => '6to.'
        ]);

    }
}
