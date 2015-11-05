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
    	for($i=0; $i<=9; $i++){
    		DB::table('users')->insert([
    			'id' =>	'ad_000000'.$i,
	            'fullname' => 'admin'.$i.' Full Name',
	            'email' => 'admin'.$i.'@schoolm.com',
	            'password' => bcrypt('1234'),
                'role' => '0',
        	]);
            DB::table('users')->insert([
                'id' => 'te_000000'.$i,
                'fullname' => 'teacher'.$i.' Full Name',
                'email' => 'teacher'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'role' => '1',
            ]);
            DB::table('users')->insert([
                'id' => 'st_000000'.$i,
                'fullname' => 'student'.$i.' Full Name',
                'email' => 'student'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'role' => '2',
            ]);
            DB::table('users')->insert([
                'id' => 'pa_000000'.$i,
                'fullname' => 'parent'.$i.' Full Name',
                'email' => 'parent'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'role' => '2',
            ]);
    	}
    }
}
