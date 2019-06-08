<?php

use App\Models\Admin\Nivel;
use Illuminate\Database\Seeder;

class NivelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nivel::create([
            'tipo_id'=>1, 'nombre'=>'Preescolar','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>1, 'nombre'=>'Primaria','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>1, 'nombre'=>'Secundaria','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>2, 'nombre'=>'USAER','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>2, 'nombre'=>'CAM','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>3, 'nombre'=>'Bachillerato','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>3, 'nombre'=>'Profesional Técnico','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>4, 'nombre'=>'Capacitación para el Trabajo','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>5, 'nombre'=>'Licenciatura','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>5, 'nombre'=>'Licenciatura S.A.','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>5, 'nombre'=>'Posgrado','status'=>true
        ]);

        Nivel::create([
            'tipo_id'=>5, 'nombre'=>'Posgrado S.A.','status'=>true
        ]);
    }
}
