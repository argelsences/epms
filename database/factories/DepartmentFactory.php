<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
        'facebook' => $faker->url,
        'instagram' => $faker->url,
        'logo_path' => '',
        'page_header_bg_color' => $faker->hexColor,
        'page_bg_color' => $faker->hexColor,
        'page_text_color' => $faker->hexColor,
        'google_analytics_code' => '',
        'google_tag_manager_code' => '',
        'url' => $faker->unique()->url,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
