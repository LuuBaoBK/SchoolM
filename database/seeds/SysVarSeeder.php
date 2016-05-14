<?php

use Illuminate\Database\Seeder;

class SysVarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sysvar')->insert([
    			'id' =>	'a_next_id',
	            'value' => '9',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	't_next_id',
	            'value' => '24',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	's_next_id',
	            'value' => '499',            	  
    	]);
    	DB::table('sysvar')->insert([
    			'id' =>	'p_next_id',
	            'value' => '449',            	  
    	]);
        DB::table('sysvar')->insert([
                'id' => 'sub_next_id',
                'value' => '14',
        ]);
        DB::table('sysvar')->insert([
                'id' => 'tkb_date',
                'value' => '0',
        ]);
    }
}
