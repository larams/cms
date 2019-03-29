<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call( StructureItemSeeder::class);
        $this->call( StructureTypeSeeder::class);
        $this->call( UsersTableSeeder::class);
        $this->call( PermissionsTableSeeder::class);

        Model::reguard();
    }
}
