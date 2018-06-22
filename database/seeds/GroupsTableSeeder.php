<?php

use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //seed 5 groups for all users in the system
        foreach (User::all() as $user) {
            factory(Group::class, 5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
