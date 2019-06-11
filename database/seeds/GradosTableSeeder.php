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

        Grado::create([
            'escuela_id'  => 1,
            'nombre'      => 'Principiante',
            'abreviacion' => 'P'
        ]);

        Grado::create([
            'escuela_id'  => 1,
            'nombre'      => 'Intermedio',
            'abreviacion' => 'I'
        ]);

        Grado::create([
            'escuela_id'  => 1,
            'nombre'      => 'Avanzado',
            'abreviacion' => 'A'
        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Primero',
//            'abreviacion' => '1ero.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Segundo',
//            'abreviacion' => '2do.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Tercero',
//            'abreviacion' => '3ero.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Cuarto',
//            'abreviacion' => '4to.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Quinto',
//            'abreviacion' => '5to.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela2,
//            'nombre'      => 'Sexto',
//            'abreviacion' => '6to.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela3,
//            'nombre'      => 'primer grado',
//            'abreviacion' => '1ero.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela3,
//            'nombre'      => 'segundo grado',
//            'abreviacion' => '2do.'
//        ]);
//
//        Grado::create([
//            'escuela_id'  => $escuela3,
//            'nombre'      => 'tercer grado',
//            'abreviacion' => '3ero..'
//        ]);

    }
}
