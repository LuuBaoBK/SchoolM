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

        $group = array(1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,12, 13, 14, 1, 2, 3, 4, 5, 1, 2, 3, 12 , 3, 7);
        $count = 0;
        for($i=0; $i<=9; $i++){
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
    		DB::table('teachers')->insert([
    			'id' =>	't_000000'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => $group[$count++],
                'position' => rand(2,6),
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,
        	]);
    	}
        for($i=0; $i<=9; $i++){
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
            DB::table('teachers')->insert([
                'id' => 't_000001'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => $group[$count++],
                'position' => rand(2,6),
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,
            ]);
        }

        for($i=0; $i < 4; $i++){
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
            DB::table('teachers')->insert([
                'id' => 't_000002'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => $group[$count++],
                'position' => rand(2,6),
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,
            ]);
        }
    }
}
