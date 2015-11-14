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
    			'id' =>	'a_000000'.$i,
	            'firstname' => 'admin'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
	            'email' => 'a_000000'.$i.'@schoolm.com',
	            'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '0',
        	]);
            DB::table('users')->insert([
                'id' => 't_000000'.$i,
                'firstname' => 'teacher'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 't_000000'.$i.'@schoolm.com',
                'dateofbirth' => "2014-11-".$i,
                'password' => bcrypt('1234'),
                'role' => '1',
            ]);
            DB::table('users')->insert([
                'id' => 's_000000'.$i,
                'firstname' => 'student'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 's_000000'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '2',
            ]);
            DB::table('users')->insert([
                'id' => 'p_000000'.$i,
                'firstname' => 'parent'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 'p_000000'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '2',
            ]);
    	}
        for($i=0; $i<=9; $i++){
            DB::table('users')->insert([
                'id' => 'a_000001'.$i,
                'firstname' => 'admin'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 'a_000001'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '0',
            ]);
            DB::table('users')->insert([
                'id' => 't_000001'.$i,
                'firstname' => 'teacher'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 't_000001'.$i.'@schoolm.com',
                'dateofbirth' => "2014-11-".$i,
                'password' => bcrypt('1234'),
                'role' => '1',
            ]);
            DB::table('users')->insert([
                'id' => 's_000001'.$i,
                'firstname' => 'student'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 's_000001'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '2',
            ]);
            DB::table('users')->insert([
                'id' => 'p_000001'.$i,
                'firstname' => 'parent'.$i,
                'middlename' => 'middle'.$i,
                'lastname' => 'last'.$i,
                'email' => 'p_000001'.$i.'@schoolm.com',
                'password' => bcrypt('1234'),
                'dateofbirth' => "2015-11-".$i,
                'role' => '2',
            ]);
        }
    }
}
