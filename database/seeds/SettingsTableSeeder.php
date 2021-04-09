<?php

use App\Models\Setting;
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
        Setting::create(['display_name' => 'Site Title', 'key' => 'site_title', 'value' => 'Bloggi System', 'type' => 'text', 'section' => 'General', 'ordering' => 1]);
        Setting::create(['display_name' => 'Site Slogan', 'key' => 'site_slogan', 'value' => 'Amazing Blog', 'type' => 'text', 'section' => 'General', 'ordering' => 2]);
        Setting::create(['display_name' => 'Site Description', 'key' => 'site_desc', 'value' => 'Bloggi Content Management System', 'type' => 'text', 'section' => 'General', 'ordering' => 3]);
        Setting::create(['display_name' => 'Site Keywords', 'key' => 'site_keywords', 'value' => 'Bloggi, blog, multi writer', 'type' => 'text', 'section' => 'General', 'ordering' => 4]);
        Setting::create(['display_name' => 'Site Email', 'key' => 'site_email', 'value' => 'admin@bloggi.test', 'type' => 'text', 'section' => 'General', 'ordering' => 5]);
        Setting::create(['display_name' => 'Site Status', 'key' => 'site_status', 'value' => 'Active', 'type' => 'text', 'section' => 'General', 'ordering' => 6]);
        Setting::create(['display_name' => 'Admin Title', 'key' => 'site_title', 'value' => 'Bloggi', 'type' => 'text', 'section' => 'General', 'ordering' => 7]);
        Setting::create(['display_name' => 'Phone Number', 'key' => 'phone_number', 'value' => '002491235655', 'type' => 'text', 'section' => 'General', 'ordering' => 8]);
        Setting::create(['display_name' => 'Address', 'key' => 'address', 'value' => 'Alridown, Soba West, Khartuom Sudan', 'type' => 'text', 'section' => 'General', 'ordering' => 9]);


        Setting::create(['display_name' => 'Facebook ID', 'key' => 'facebook_id', 'value' => 'Alridown, Soba West, Khartuom Sudan', 'type' => 'text', 'section' => 'Social Media', 'ordering' => 1]);
        Setting::create(['display_name' => 'Twitter ID', 'key' => 'twitter_id', 'value' => 'Alridown, Soba West, Khartuom Sudan', 'type' => 'text', 'section' => 'Social Media', 'ordering' => 2]);
        Setting::create(['display_name' => 'Instagram ID', 'key' => 'instagram_id', 'value' => 'Alridown, Soba West, Khartuom Sudan', 'type' => 'text', 'section' => 'Social Media', 'ordering' => 3]);
        Setting::create(['display_name' => 'Youtube ID', 'key' => 'youtube_id', 'value' => 'Alridown, Soba West, Khartuom Sudan', 'type' => 'text', 'section' => 'Social Media', 'ordering' => 4]);
    }
}
