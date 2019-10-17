<?php

use Illuminate\Database\Seeder;
use App\User;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weyler = User::where('email', 'uicabpatweyler@gmail.com')->first();
        $wendy = User::where('email', 'wchulim.academiairlanda@gmail.com')->first();

        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrador',
        ]);

        Bouncer::ability()->firstOrCreate([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*'
        ]);

        Bouncer::allow('admin')->everything();
        Bouncer::assign('admin')->to($weyler);
        Bouncer::assign('admin')->to($wendy);
    }
}
