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
            'subject_name' => 'N/A',
            'total_time' => '0'   
        ]);
		DB::table('subjects')->insert([
            'subject_name' => 'Toán',
            'total_time' => '6'	  
    	]);
        DB::table('subjects')->insert([
            'subject_name' => 'Vật Lý',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Hóa Học',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Sinh Học',
            'total_time' => '8'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Lịch Sử',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Địa Lý',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Ngữ Văn',
            'total_time' => '6'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'GDCD',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Thể Dục',
            'total_time' => '2'   
        ]);
        DB::table('subjects')->insert([
            'subject_name' => 'Tin Học',
            'total_time' => '2'   
        ]);
    }
}
