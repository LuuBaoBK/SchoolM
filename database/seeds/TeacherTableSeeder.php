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
        $group = array(
            '0' => 'Toán',
            '1' => 'Vật Lý',
            '2' => 'Hóa Học',
            '3' => 'Sinh Học',
            '4' => 'Lịch Sử',
            '5' => 'Địa Lý',
            '6' => 'Ngữ Văn',
            '7' => 'GDCD',
            '8' => 'Thể Dục',
            '9' => 'Tin Học',
        );
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
                'group' => $group[$i],
                'position' => 'giao vien',
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
                'group' => $group[$i],
                'position' => 'giao vien',
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,              
            ]);
        }
    }
}
