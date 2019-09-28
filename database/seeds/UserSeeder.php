<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $uesr = \App\Entities\User::create([
            'name'     => 'Sadeq',
            'family'   => 'Hajizadeh',
            'email'    => 'sadegh.h.2007@gmail.com',
            'password' => bcrypt('123456'),
            'mobile'   => '09352760765'
        ]);
    }
}
