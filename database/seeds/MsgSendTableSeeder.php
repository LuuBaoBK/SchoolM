<?php

use Illuminate\Database\Seeder;

class MsgSendTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=40;$i++){
            DB::table('msgsend')->insert([
                'id' => $i,
                'sendby' => 'a_0000000',
                'isdelete' => rand(0,1),
                'isdraft' => rand(0,1),     
            ]);
        }
    }
}
