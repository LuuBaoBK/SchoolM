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

        for($i=0; $i < 5; $i++){
            DB::table('classes')->insert([
                'id' => '14_9_A_'.($i+1),
                'scholastic' => '14',
                'classname' => '9A'.($i+1),
                'homeroom_teacher' => 't_000000'.$i,
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
            ]);
        }
        for($i=0; $i < 10; $i++){
    		DB::table('classes')->insert([
    			'id' =>	'15_9_A_'.($i+1),
	            'scholastic' => '15',
	            'classname' => '9A'.($i+1),
	            'homeroom_teacher' => 't_000000'.$i,
                'doable_from' => '',
                'doable_to' => '',
                'doable_month' => '0',
        	]);
    	}
    }
}
