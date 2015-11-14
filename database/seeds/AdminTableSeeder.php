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
    		DB::table('admin')->insert([
    			'id' =>	'a_000000'.$i,
                'create_by' => 'a_000000'.$i,
                'mobilephone' => '091-333'.$i,
        	]);
    	}
        for($i=0; $i<=9; $i++){
            DB::table('admin')->insert([
                'id' => 'a_000001'.$i,
                'create_by' => 'a_000000'.$i,
                'mobilephone' => '091-333'.$i,
            ]);
        }
    }
}
