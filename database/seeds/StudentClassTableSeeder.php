<?php

use Illuminate\Database\Seeder;

class StudentClassTableSeeder extends Seeder
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
            $conduct = rand(0,2);
            $ispass = rand(0,1);
            $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
    		DB::table('studentclass')->insert([
    			'class_id' 		=>	'15_9_A_'.$class,
                'student_id'	=> 's_000000'.$i,
                'conduct' 		=> $conducttype[$conduct],
                'ispassed' 		=> $ispass,
        	]);
    	}
        for($i=0; $i<=9; $i++){
            $class = ($i <4)? "1" : "2";
            $conduct = rand(0,2);
            $ispass = rand(0,1);
            $conducttype = array('0' => 'good' , '1' => 'bad', '2' => 'excellent');
    		DB::table('studentclass')->insert([
    			'class_id' 		=>	'15_9_A_'.$class,
                'student_id'	=> 's_000001'.$i,
                'conduct' 		=> $conducttype[$conduct],
                'ispassed' 		=> $ispass,
        	]);
        }
    }
}
