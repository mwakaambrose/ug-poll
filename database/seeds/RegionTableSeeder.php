<?php

use App\Models\Region;
use App\Models\District;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Central' => [
                'Kampala',
                'Wakiso',
                'Mukono',
            ],
            'Eastern' => [
                'Jinja',
                'Mbale',
                'Soroti',
                'Serere',
                'Kamuli',
                'Iganga',
            ],
            'Northern' => [
                'Gulu',
                'Kitgum',
                'Lira',
                'Pader',
                'Lamwo',
            ],
            'Western' => [
                'Kasese',
                'Rukiga',
                'Kabale',
                'Mbarara',
                'Hoima',
                'Bushenyi',
            ],
            'Southern' => [
                'Masaka',
                'Mpigi',
                'Rakai',
                'Mubende',
            ],
        ];

        foreach ($regions as $name => $districts) {
            Region::create([
                'name' => $name
            ]);

            $region = Region::get()->last();

            foreach ($districts as $district) {
                District::create([
                    'region_id' => $region->id,
                    'name'      => $district
                ]);
            }
        }
    }
}
