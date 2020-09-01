<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venue;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->streetName,
        'address_line_1' => $faker->unique()->address,
        'address_line_2' => $faker->secondaryAddress,
        'country' => $faker->country,
        'state' => $faker->state,
        'postcode' => $faker->postcode,
        'lat' => $faker->latitude(-90, 90),
        'long' => $faker->longitude(-180, 180),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
