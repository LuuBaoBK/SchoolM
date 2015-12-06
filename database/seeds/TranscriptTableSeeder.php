<?php

use Illuminate\Database\Seeder;

class TranscriptClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
            $class = ($i <7)? "1" : "2";
            $rtype = rand(0,3);
            $type = array('0' => '15 phút' , '1' => '1 tiết', '2' => 'Thi giữa kì', '3' => 'Thi cuối kì');
    		DB::table('studentclass')->insert([
    			'class_id' 		=>	'15_9_A_'.$class,
                'student_id'	=> 's_000000'.$i,
                'conduct' 		=> $conducttype[$conduct],
                'ispassed' 		=> $ispass,
        	]);
    	}
        
    }
}
