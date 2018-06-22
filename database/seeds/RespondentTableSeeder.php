<?php

use App\Models\User;
use App\Models\District;
use App\Models\Respondent;
use Illuminate\Database\Seeder;

class RespondentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            foreach (District::all() as $district) {
                factory(Respondent::class, rand(3, 10))->create([
                    'district_id' => $district->id
                ]);

                foreach (Respondent::where('district_id', $district->id)->get() as $respondent) {
                    //get any 2 random groups that belong to the user and pluck their id into an array
                    $groups = $user->groups()->inRandomOrder()->limit(2)->get()->pluck('id')->toArray();

                    //add the respondent to the groups from the previous step
                    $respondent->groups()->attach($groups);
                }
            }
        }
    }
}
