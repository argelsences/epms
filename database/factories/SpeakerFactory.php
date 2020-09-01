<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Speaker;
use Faker\Generator as Faker;

$factory->define(Speaker::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->name,
        'profile' => $this->faker->paragraph(mt_rand(3, 6)),
        'photo' => '',
        'department_id' => $faker->numberBetween(1,20),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
