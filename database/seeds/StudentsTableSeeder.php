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
            $year = ($i <7)? "2013" : "2011";
    		DB::table('students')->insert([
    			'id' =>	's_000000'.$i,
                'enrolled_year' => $year,
                'graduated_year' => $year + 4,
                'parent_id' => 'p_000000'.$i,
        	]);
    	}
        for($i=0; $i<=9; $i++){
            $year = ($i <4)? "2013" : "2011";
            DB::table('students')->insert([
                'id' => 's_000001'.$i,
                'enrolled_year' => $year,
                'graduated_year' => $year + 4,
                'parent_id' => 'p_000000'.$i,
            ]);
        }
    }
}
