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
        for($i=0;$i<10;$i++){
            DB::table('msgsend')->insert([
                'id' => $i,
                'sendby' => 'a_0000000',
                'isdelete' => '0',
                'isdraft' => '0',     
            ]);
        }
    }
}
