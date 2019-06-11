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
        $inicio = 2018;
        $fin = 2019;
        foreach(range(1,1) as $i){
            Ciclo::create([
                'periodo' => $inicio.'-'.$fin,
                'status' => true
            ]);
            $inicio++;
            $fin++;
        }
    }
}
