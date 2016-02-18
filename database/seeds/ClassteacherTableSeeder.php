<?php

use Illuminate\Database\Seeder;

class ClassteacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10; $i++){
    		DB::table('classteacher')->insert([
    			'class_id' =>	'15_9_A_1',
	            'teacher_id' => 't_000000'.$i,
        	]);
    	}
    }
}
