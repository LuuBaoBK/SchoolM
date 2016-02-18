<?php

use Illuminate\Database\Seeder;

class ScoretypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_list = array(
            '0' => '15\' (1)',
            '1' => '15\' (2)',
            '2' => '45\' (1)',
            '3' => '45\' (2)',
            '4' => 'GK',
            '5' => 'CK',
        );
        $factor_list = array(
            '0' => '1',
            '1' => '1',
            '2' => '2',
            '3' => '2',
            '4' => '2',
            '5' => '3',
        );
        for($k=0; $k<6; $k++){
            DB::table('scoretype')->insert([
                'type' => $type_list[$k],
                'factor' => $factor_list[$k]
            ]);
    	}
    }
}
