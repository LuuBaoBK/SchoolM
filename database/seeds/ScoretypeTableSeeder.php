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
        for($i=2; $i<=11; $i++){
            for($k=8; $k<=11; $k++){
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '15_'.$k,
                    'factor' => '1',
                    'applyfrom' => '9',
                    'month' => $k,
                ]);
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '45_'.$k,
                    'factor' => '2',
                    'applyfrom' => '9',
                    'month' => $k,
                ]);
                if($k == 9 || $k == 11){
                    DB::table('scoretype')->insert([
                        'subject_id' => $i, 
                        'type' => 'M_'.$k,
                        'factor' => '1',
                        'applyfrom' => '9',
                        'month' => $k,
                    ]);
                }
            }
            DB::table('scoretype')->insert([
                'subject_id' => $i, 
                'type' => 'CK_1',
                'factor' => '3',
                'applyfrom' => '9',
                'month' => '12',
            ]); 
            for($k=1; $k<=4; $k++){
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '15_'.$k,
                    'factor' => '1',
                    'applyfrom' => '9',
                    'month' => $k,
                ]);
                DB::table('scoretype')->insert([
                    'subject_id' => $i, 
                    'type' => '45_'.$k,
                    'factor' => '2',
                    'applyfrom' => '9',
                    'month' => $k,
                ]);
                if($k == 2 || $k == 4){
                    DB::table('scoretype')->insert([
                        'subject_id' => $i, 
                        'type' => 'M_'.$k,
                        'factor' => '1',
                        'applyfrom' => '9',
                        'month' => $k,
                    ]);
                }
            }
            DB::table('scoretype')->insert([
                'subject_id' => $i, 
                'type' => 'CK_2',
                'factor' => '3',
                'applyfrom' => '9',
                'month' => '12',
            ]);   
        } 
    }
}
