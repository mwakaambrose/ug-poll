<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(RespondentTableSeeder::class);
    }
}
