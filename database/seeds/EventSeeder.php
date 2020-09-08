<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // check if environment is development, then proceed to factory
        if (App::environment('local')) {
            // create 50 random departments
            factory('App\Event', 50)->create();
        }
    }
}
