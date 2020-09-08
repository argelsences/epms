<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            SpeakerSeeder::class,
            VenueSeeder::class,
            RolesAndPermissionSeeder::class,
            UsersTableSeeder::class,
            EventSeeder::class,
        ]);
    }
}
