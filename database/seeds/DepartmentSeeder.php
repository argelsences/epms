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

    }
}
