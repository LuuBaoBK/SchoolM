<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
    		DB::table('students')->insert([
    			'id' =>	's_000000'.$i,
                'enrolled_year' => '200'.$i,
                'graduated_year' => '200'.($i+4),
                'parent_id' => 'p_000000'.$i,
        	]);
    	}
    }
}
