<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $department = DB::table('departments')->insert([
            'name'       => 'Engineering Systems and Design',
            'email'      => 'esd@sutd.edu.sg',
            'url'        => 'esd',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // check if environment is development, then proceed to factory
        if (App::environment('local')) {
            // create 50 random departments
            factory('App\Department', 50)->create();
        }

    }
}
