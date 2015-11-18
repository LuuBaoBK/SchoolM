<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++)
        {
            for($j=1; $j<=10; $j++)
            {
    		  DB::table('schedules')->insert([
    			'class_id' =>	'15_9_A_1',
	            'subject_id' => rand(1, 9),
	            'day' => $i,
                'start_at' => $j,
                'duration' => 1,             	  
        	   ]);
            }
    	}
    }
}
