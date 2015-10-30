<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i=1; $i<=10; $i++){
    		DB::table('users')->insert([
    			'id' =>	'ad_'.$i,
	            'fullname' => 'user'.$i.'Full Name',
	            'email' => 'user'.$i.'@schoolm.com',
	            'password' => bcrypt('1234'),
        	]);
    	}        
    }
}
