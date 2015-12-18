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
        for($i=1;$i<=40;$i++){
            DB::table('msgrecv')->insert([
                'id' => $i,
                'recvby' => 'a_0000001',
                'isdelete' => rand(0,1),
                'isread' => rand(0,1),      
            ]);
        }
    }
}
