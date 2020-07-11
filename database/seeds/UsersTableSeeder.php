<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => 'Aaron Angelo Vicuna',
            'email' => 'arjieangelsences@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('logan9c20'),
            'designation' => 'Senior Specialist',
            'department_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 6,
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
    }
}
