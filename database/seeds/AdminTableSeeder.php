<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
            $mobilephone = '09';
            for($k=0; $k<7; $k++){
                $mobilephone = $mobilephone.rand(0,9);
            }
    		DB::table('admin')->insert([
    			'id' =>	'a_000000'.$i,
                'create_by' => 'a_000000'.$i,
                'mobilephone' => $mobilephone
        	]);
    	}
    }
}
