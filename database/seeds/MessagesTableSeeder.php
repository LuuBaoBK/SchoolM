<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        for($i=0;$i<40;$i++){
            DB::table('messages')->insert([
                'content' => '<b>This is <u>Messeage</u> Number</b>'.$i,
                'title' => 'Title number : '.$i.'',
                'created_at' => $date
            ]);
        }
    }
}
