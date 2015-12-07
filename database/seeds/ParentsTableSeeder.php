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
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
    		DB::table('parents')->insert([
    			'id' =>	'p_000000'.$i,
	            'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'job' => 'parent job',              	  
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
            DB::table('parents')->insert([
                'id' => 'p_000001'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'job' => 'parent job',                    
            ]);
        }
    }
}
