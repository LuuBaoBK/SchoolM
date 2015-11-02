<?php

use Illuminate\Database\Seeder;

class ParentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
    		DB::table('parents')->insert([
    			'id' =>	'pa_000'.$i,
	            'mobilephone' => '090-111-'.$i,
                'homephone' => '08-111-'.$i,
                'job' => 'parent job',              	  
        	]);
    	}
    }
}
