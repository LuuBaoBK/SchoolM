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
        for($i=1; $i<=14; $i++){
            for($k=8; $k<=11; $k++){
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '15_phut',
                    'factor' => '1',
                    'applyfrom' => '9',
                    'disablefrom' => '3000',
                    'month' => $k,
                ]);
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '1_tiett',
                    'factor' => '2',
                    'applyfrom' => '9',
                    'disablefrom' => '3000',
                    'month' => $k,
                ]);
                if($k == 9 || $k == 11){
                    DB::table('scoretype')->insert([
                        'subject_id' => $i, 
                        'type' => 'Kt_Mieng',
                        'factor' => '1',
                        'applyfrom' => '9',
                        'disablefrom' => '3000',
                        'month' => $k,
                    ]);
                }
            }
            DB::table('scoretype')->insert([
                'subject_id' => $i, 
                'type' => 'CK_1',
                'factor' => '3',
                'applyfrom' => '9',
                'disablefrom' => '3000',
                'month' => '12',
            ]); 
            for($k=1; $k<=4; $k++){
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '15_phut',
                    'factor' => '1',
                    'applyfrom' => '9',
                    'disablefrom' => '3000',
                    'month' => $k,
                ]);
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '1_tiet',
                    'factor' => '2',
                    'applyfrom' => '9',
                    'disablefrom' => '3000',
                    'month' => $k,
                ]);
                if($k == 2 || $k == 4){
                    DB::table('scoretype')->insert([
                        'subject_id' => $i, 
                        'type' => 'Kt_Mieng',
                        'factor' => '1',
                        'applyfrom' => '9',
                        'disablefrom' => '3000',
                        'month' => $k,
                    ]);
                }
            }
            DB::table('scoretype')->insert([
                'subject_id' => $i, 
                'type' => 'CK_2',
                'factor' => '3',
                'applyfrom' => '9',
                'disablefrom' => '3000',
                'month' => '12',
            ]);   
        } 
    }
}
