<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        	[
	            'name' => 'ThinkSumo Developer',
	            'email' => 'dev@sumofy.me',
	            'password' => bcrypt('qweasd'),
	            'cms' => '1',
	            'verified' => '1',
	            'status' => 'active',
	            'type' => 'super'
        	]
        );

        DB::table('users')->insert(
            [
                'name' => 'Derrick Nicolas',
                'email' => 'derrick.nicolas@sumofy.me',
                'password' => bcrypt('qweasd'),
                'cms' => '1',
                'verified' => '1',
                'status' => 'active',
                'type' => 'super'
            ]
        );
    }
}
