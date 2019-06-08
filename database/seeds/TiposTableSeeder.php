<?php

use App\Models\Admin\Tipo;
use Illuminate\Database\Seeder;

class TiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create(['nombre'=>'Educación Básica','status'=>true]);
        Tipo::create(['nombre'=>'Educación Especial','status'=>true]);
        Tipo::create(['nombre'=>'Educación Media Superior','status'=>true]);
        Tipo::create(['nombre'=>'Capacitación Para El Trabajo','status'=>true]);
        Tipo::create(['nombre'=>'Educación Superior','status'=>true]);
    }
}
