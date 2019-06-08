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
            'tipo_id' => 4,
            'nivel_id' => 8,
            'servicio_id' => 20,
            'nombre' => 'academia de inglés: irlanda',
            'cct' => '23PBT0035N',
            'turno' => 'Vespertino',
            'sostenimiento' => 'Privado'
        ]);

        Escuela::create([
            'tipo_id' => 1,
            'nivel_id' => 2,
            'servicio_id' => 5,
            'nombre' => 'crescencio carrillo y ancona',
            'cct' => '31PPR0379E',
            'turno' => 'Matutino',
            'sostenimiento' => 'Privado'
        ]);

        Escuela::create([
            'tipo_id' => 1,
            'nivel_id' => 3,
            'servicio_id' => 8,
            'nombre' => 'crescencio carrillo y ancona',
            'cct' => '31PES0080Q',
            'turno' => 'Matutino',
            'sostenimiento' => 'Privado'
        ]);

        Escuela::create([
            'tipo_id' => 3,
            'nivel_id' => 6,
            'servicio_id' => 16,
            'nombre' => 'crescencio carrillo y ancona',
            'cct' => '31PBH0024V',
            'turno' => 'Matutino',
            'sostenimiento' => 'Privado'
        ]);
    }
}
