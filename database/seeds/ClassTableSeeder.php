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
        for($i=1; $i<=3; $i++){
    		DB::table('classes')->insert([
    			'id' =>	'15_9_A_'.$i,
	            'scholastic' => '15',
	            'classname' => '9A'.$i,
	            'homeroom_teacher' => 't_000000'.$i,
                'doable_from' => '-1',
                'doable_to' => '-1',
                'doable_type' => '1'
        	]);
    	}
    }
}
