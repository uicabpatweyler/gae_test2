<?php

use App\Models\Config\Escuela;
use Illuminate\Database\Seeder;

class EscuelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Escuela::create([
            'cct' => '23PBT0035N',
            'incorporacion' => 'ICAT17001CT',
            'nombre' => 'Academia de Inglés: Irlanda',
            'tipo_id' => 4,
            'nivel_id' => 8,
            'servicio_id' => 20,
            'turno' => 'Vespertino',
            'sostenimiento' => 'Privado',
            'email' => 'academiairlanda@hotmail.com',
            'telefono' => '(983)-837-6466',
            'calle' => 'Calle Faisán',
            'exterior' => '147',
            'entrecalles' => 'Entre Chablé y Retorno 3',
            'colonia' => 'Payo Obispo II',
            'codpost' => '77083',
            'pais' => 'México',
            'entidad' => 'Quintana Roo',
            'municipio' => 'Othón P. Blanco',
            'localidad' => 'Chetumal'
        ]);
//
//        Escuela::create([
//            'tipo_id' => 1,
//            'nivel_id' => 2,
//            'servicio_id' => 5,
//            'nombre' => 'crescencio carrillo y ancona',
//            'cct' => '31PPR0379E',
//            'turno' => 'Matutino',
//            'sostenimiento' => 'Privado'
//        ]);
//
//        Escuela::create([
//            'tipo_id' => 1,
//            'nivel_id' => 3,
//            'servicio_id' => 8,
//            'nombre' => 'crescencio carrillo y ancona',
//            'cct' => '31PES0080Q',
//            'turno' => 'Matutino',
//            'sostenimiento' => 'Privado'
//        ]);
//
//        Escuela::create([
//            'tipo_id' => 3,
//            'nivel_id' => 6,
//            'servicio_id' => 16,
//            'nombre' => 'crescencio carrillo y ancona',
//            'cct' => '31PBH0024V',
//            'turno' => 'Matutino',
//            'sostenimiento' => 'Privado'
//        ]);
    }
}
