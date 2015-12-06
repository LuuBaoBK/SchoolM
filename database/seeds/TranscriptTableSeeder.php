<?php

use Illuminate\Database\Seeder;

class TranscriptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
        	for($s=0; $s<=9; $s++){
    			DB::table('transcript')->insert([
	    			'student_id' =>	's_000000'.$i,
	                'semester' => '15_1',
	                'subject_id' => $s,
	                'type' => 'type'.$i,
	                'score' => $s,              
        		]);
        	}
    	}
    }
}
