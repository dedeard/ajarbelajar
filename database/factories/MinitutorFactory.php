<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Minitutor;
use Faker\Generator as Faker;

$factory->define(Minitutor::class, function (Faker $faker) {
    return [
        'last_education' => ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'][$faker->numberBetween(0, 5)],
        'university' => $faker->company,
        'city_and_country_of_study' => $faker->city . ', ' . $faker->country,
        'majors' => $faker->jobTitle,
        'contact' => $faker->phoneNumber,
        'interest_talent' => $faker->realText(80),
        'reason' => $faker->realText(250),
        'expectation' => $faker->realText(250),
        'active' => $faker->boolean()
    ];
});
