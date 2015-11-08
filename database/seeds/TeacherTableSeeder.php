<?php

use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
    		DB::table('teachers')->insert([
    			'id' =>	'te_000000'.$i,
                'mobilephone' => '090-000-'.$i,
                'homephone' => '08-000-'.$i,
                'group' => $i,
                'position' => 'giao vien',
                'specialize' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,              
        	]);
    	}
    }
}
