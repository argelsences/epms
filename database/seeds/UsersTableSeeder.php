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

        // make a role permission factory first
        factory(App\User::class, 50)->create()->each(function($u) {
            //$u->posts()->save(factory(App\Post::class)->make());
            $roles = \Spatie\Permission\Models\Role::all();
            $roleArray = $roles->pluck('name');
            $the_role = $roleArray([range(0, count($roleArray) - 1)]);
            $u->assignRole($the_role);
        });
    }
}
