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
            'email'     => 'piruville@gmail.com',
            'password'  => 'password'
        ]);

        // add your own user seeders here to that you dont have to recreate the user every time
    }
}
