<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $setting = DB::table('settings')->insert([
            'name'       => 'number_of_days_archive',
            'value'      => '365',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'default_image_output',
            'value'      => 'JPG',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'header_bg_color',
            'value'      => '#0D7377',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'bg_color',
            'value'      => '#EEEEEE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'text_color',
            'value'      => '#FFFFFF',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'is_facebook',
            'value'      => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'is_twitter',
            'value'      => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'is_linkedin',
            'value'      => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'is_email',
            'value'      => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'is_whatsapp',
            'value'      => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $setting = DB::table('settings')->insert([
            'name'       => 'timezone',
            'value'      => 'Asia/Singapore',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
