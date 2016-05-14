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
        for($i=0; $i<=499; $i++){
            $offset = 9-strlen($i);
            $id = substr('s_0000000', 0,$offset);
            $id = $id.$i;
            if($i <= 449){
                $parent_id = substr('p_0000000', 0,$offset);
                $parent_id .= $i;
            }
            else{
                $temp = $i - 450;
                $offset = 9-strlen($temp);
                $parent_id = substr('p_0000000', 0,$offset);
                $parent_id .= $temp;
            }
            
            if($i <= 59){
                $year = 2011;
            }
            else if($i <= 139){
                $year = 2012;
            }
            else if($i <= 239){
                $year = 2013;
            }
            else if($i <= 359){
                $year = 2014;
            }
            else{
                $year = 2015;
            }

    		DB::table('students')->insert([
    			'id' =>	$id,
                'enrolled_year' => $year,
                'graduated_year' => 0,
                'parent_id' => $parent_id,
        	]);
    	}
    }
}
