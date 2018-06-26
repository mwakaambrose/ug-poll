<?php

$factory->define(App\Models\Respondent::class, function ($faker) {
    $faker = Faker\Factory::create('en_UG');

    return [
        'name'          => $faker->name,
        'phone_number'  => $faker->unique()->phoneNumber,
        'address'       => $faker->address,
        'gender'        => $faker->randomElement(['Male', 'Female']),
        'email_address'         => $faker->email,
    ];
});
