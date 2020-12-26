<?php

use Illuminate\Database\Seeder;

class ReserveStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $reserveStatus = DB::table('reserve_statuses')->insert([
            'name'       => 'Completed',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $reserveStatus = DB::table('reserve_statuses')->insert([
            'name'       => 'Refunded',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $reserveStatus = DB::table('reserve_statuses')->insert([
            'name'       => 'Partially Refunded',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $reserveStatus = DB::table('reserve_statuses')->insert([
            'name'       => 'Cancelled',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $reserveStatus = DB::table('reserve_statuses')->insert([
            'name'       => 'Awaiting Payment',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
