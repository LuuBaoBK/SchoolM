<?php

use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('subjects')->insert([
            'id'           => '0',
            'subject_name' => 'Toán',
            'total_time' => '6'	  
    	]);
        DB::table('subjects')->insert([
            'id'           => '1',
            'subject_name' => 'Vật Lý',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '2',
            'subject_name' => 'Hóa Học',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '3',
            'subject_name' => 'Sinh Học',
            'total_time' => '8'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '4',
            'subject_name' => 'Lịch Sử',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '5',
            'subject_name' => 'Địa Lý',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '6',
            'subject_name' => 'Ngữ Văn',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '7',
            'subject_name' => 'GDCD',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '8',
            'subject_name' => 'Thể Dục',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'id'           => '9',
            'subject_name' => 'Tin Học',
            'total_time' => '2'   
        ]);
    }
}
