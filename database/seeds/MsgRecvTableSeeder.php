<?php

use Illuminate\Database\Seeder;

class MsgRecvTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<10;$i++){
            DB::table('msgrecv')->insert([
                'id' => $i,
                'recvby' => 'a_0000001',
                'isdelete' => '0',
                'isread' => '0',      
            ]);
        }
    }
}
