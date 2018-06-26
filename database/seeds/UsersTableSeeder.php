<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Piru',
            'email'     => 'rpiuspiru@gmail.com',
            'password'  => bcrypt('password')
        ]);

        User::create([
            'name'      => 'jcole715',
            'email'     => 'mahadizle@gmail.com',
            'password'  => bcrypt('password')
        ]);

        // add your own user seeders here to that you dont have to recreate the user every time
    }
}
