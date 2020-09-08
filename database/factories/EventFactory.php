<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Event::class, function (Faker $faker) {
    $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;
    $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addHours( $faker->numberBetween( 1, 8 ) );
    return [
        //
        'title' => $faker->unique()->text(80),
        'synopsis' => $faker->randomHtml(2,3),
        'excerpt' => $this->faker->paragraph(mt_rand(1, 2)),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'pre_booking_display_message' => $this->faker->paragraph(mt_rand(1, 2)),
        'post_booking_display_message' => $this->faker->paragraph(mt_rand(1, 2)),
        'social_show_facebook' => $faker->boolean,
        'social_show_linkedin' => $faker->boolean,
        'social_show_twitter' => $faker->boolean,
        'social_show_whatsapp' => $faker->boolean,
        'social_show_email' => $faker->boolean,
        'is_public' => $faker->boolean,
        'is_approved' => $faker->boolean,
        'for_approval' => $faker->boolean,
        'barcode_type' => '',
        'checkout_timeout' => $faker->numberBetween(60,80),
        'department_id' => $faker->numberBetween(1,20),
        'created_by' => 1,
        'edited_by' => 1,
        'venue_id' => $faker->numberBetween(1,20),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
