<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'key' => 'mailchimp_list_id',
            'value' => 'xxx'
        ]);

        DB::table('settings')->insert([
            'key' => 'use_mailchimp',
            'value' => '0'
        ]);

        DB::table('settings')->insert([
            'key' => 'user_listings_limit',
            'value' => '50'
        ]);

        DB::table('settings')->insert([
            'key' => 'contact_email',
            'value' => 'example@businessdirectory.com'
        ]);
    }
}
