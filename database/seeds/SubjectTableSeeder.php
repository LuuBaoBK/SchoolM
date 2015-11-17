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
        for($i=1; $i<10; $i++){
    		DB::table('subjects')->insert([
                'id'           => $i,
	            'subject_name' => 'subject '.$i,
	            'total_time' => $i*20,	  
        	]);
    	}   
    }
}
