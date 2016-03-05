<?php

use Illuminate\Database\Seeder;

class PhancongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0; $i < 3; $i++){
    		DB::table('phancong')->insert([
    			'class_id' =>	'14_9_A_1',
	            'teacher_id' => 't_000000'.$i,
        	]);
    	}

    }
}
