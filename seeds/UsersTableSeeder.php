<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        $password =
            \Illuminate\Support\Str::random(6) . '-' .
            \Illuminate\Support\Str::random(6) . '-' .
            \Illuminate\Support\Str::random(6);

        $output = new ConsoleOutput();
        $output->writeln('New password for `dev` user: ' . $password);

        DB::table('users')->insert(array(
            'email' => 'dev',
            'password' => Hash::make($password),
            'name' => 'Developer',
            'role_id' => 1
        ));
    }
}
