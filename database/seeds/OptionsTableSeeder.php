<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert(
        	[
	            'name' => 'Meta Title',
	            'slug' => 'meta-title',
                'type' => 'text',
	            'permanent' => 1,
	            'value' => 'Meta Title',
	            'asset' => '',
        	]
        );

        DB::table('options')->insert(
        	[
	            'name' => 'Meta Description',
	            'slug' => 'meta-description',
	            'type' => 'text',
                'permanent' => 1,
	            'value' => 'Meta Description',
	            'asset' => '',
        	]
        );

        DB::table('options')->insert(
        	[
	            'name' => 'Meta Image',
	            'slug' => 'meta-image',
	            'type' => 'asset',
                'permanent' => 1,
	            'value' => '',
	            'asset' => '',
        	]
        );

        DB::table('options')->insert(
            [
                'name' => 'Contact Number',
                'slug' => 'contact-number',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Contact Email',
                'slug' => 'contact-email',
                'type' => 'text',
                'permanent' => 1,
                'value' => 'no-reply@sumofy.me',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Facebook Page',
                'slug' => 'facebook-page',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Twitter Page',
                'slug' => 'twitter-page',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Google Page',
                'slug' => 'google-page',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Terms Link',
                'slug' => 'terms-link',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Privacy Link',
                'slug' => 'privacy-link',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );

        DB::table('options')->insert(
            [
                'name' => 'Unsubscribe Link',
                'slug' => 'unsubscribe-link',
                'type' => 'text',
                'permanent' => 1,
                'value' => '',
                'asset' => '',
            ]
        );
    }
}
