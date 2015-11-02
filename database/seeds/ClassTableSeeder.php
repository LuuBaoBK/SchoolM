<?php

use Illuminate\Database\Seeder;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++){
    		DB::table('classes')->insert([
    			'id' =>	$i,
	            'semester' => 'subject'.$i,
	            'classname' => $i*50,
	            'homeroom_teacher' => 'te_000'.$i,	  
        	]);
    	}
    }
}
