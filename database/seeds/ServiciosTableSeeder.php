<?php

use App\Models\Admin\Servicio;
use Illuminate\Database\Seeder;

class ServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>1, 'nombre'=>'CENDI', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>1, 'nombre'=>'Preescolar General', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>1, 'nombre'=>'Preescolar Indígena', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>1, 'nombre'=>'Preescolar CONAFE', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>2, 'nombre'=>'Primaria General', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>2, 'nombre'=>'Primaria Indigena', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>2, 'nombre'=>'Primaria CONAFE', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Secundaria General', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Secundaria Técnica', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Telesecundaria', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Secundaria Comunitaria', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Secundaria Migrante', 'status'=>true]);
        Servicio::create(['tipo_id'=>1, 'nivel_id'=>3, 'nombre'=>'Secundaria Para Trabajadores', 'status'=>true]);
        Servicio::create(['tipo_id'=>2, 'nivel_id'=>4, 'nombre'=>'USAER', 'status'=>true]);
        Servicio::create(['tipo_id'=>2, 'nivel_id'=>5, 'nombre'=>'CAM', 'status'=>true]);
        Servicio::create(['tipo_id'=>3, 'nivel_id'=>6, 'nombre'=>'Bachillerato General', 'status'=>true]);
        Servicio::create(['tipo_id'=>3, 'nivel_id'=>6, 'nombre'=>'Bachillerato Técnico', 'status'=>true]);
        Servicio::create(['tipo_id'=>3, 'nivel_id'=>6, 'nombre'=>'Profesional Técnico B', 'status'=>true]);
        Servicio::create(['tipo_id'=>3, 'nivel_id'=>7, 'nombre'=>'Profesional Técnico', 'status'=>true]);
        Servicio::create(['tipo_id'=>4, 'nivel_id'=>8, 'nombre'=>'Formación para el Trabajo', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>9, 'nombre'=>'Lic. Univ. y Téc.', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>9, 'nombre'=>'Técnico Superior', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>9, 'nombre'=>'Normal', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>10, 'nombre'=>'Lic. Univ. y Téc. S.A.', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>10, 'nombre'=>'Técnico Superior S.A.', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>11, 'nombre'=>'Especialidad', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>11, 'nombre'=>'Maestría', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>11, 'nombre'=>'Doctorado', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>12, 'nombre'=>'Especialidad S.A.', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>12, 'nombre'=>'Maestría S.A.', 'status'=>true]);
        Servicio::create(['tipo_id'=>5, 'nivel_id'=>12, 'nombre'=>'Doctorado S.A.', 'status'=>true]);
    }
}
