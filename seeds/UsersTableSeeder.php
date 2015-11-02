<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert( array(
            'email' => 'dev',
            'password' => '$2y$10$aU.kj5BptrswUomyW/9Hj.TVkf.3BW.QFD7GLI1l9BsRSXGTNkm2O',
            'name' => 'Developer',
            'type' => 'DEV'
        ));


    }

}