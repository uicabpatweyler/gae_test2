<?php

use App\Models\Config\Ciclo;
use Illuminate\Database\Seeder;

class CiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inicio = 1998;
        $fin = 1999;
        foreach(range(1,20) as $i){
            Ciclo::create([
                'periodo' => $inicio.'-'.$fin,
                'status' => true
            ]);
            $inicio++;
            $fin++;
        }
    }
}
