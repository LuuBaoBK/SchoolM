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
        for($i=0; $i<=449; $i++){
            $offset = 9-strlen($i);
            $id = substr('p_0000000', 0,$offset);
            $id = $id.$i;
            $mobilephone = '09';
            $homephone = '08';
            for($k=0; $k<8; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                $homephone = $homephone.rand(0,9);
            }
    		DB::table('parents')->insert([
    			'id' =>	$id,
	            'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'job' => 'parent job',              	  
        	]);
    	}
    }
}
