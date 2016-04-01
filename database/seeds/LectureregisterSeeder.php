<?php

use Illuminate\Database\Seeder;

class LectureregisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i = 1; $i<100; $i++){
    		$notice_date = '2016-03-'.rand(28,31);
            $day = date_create($notice_date);
    		DB::table('lectureregister')->insert([
                'teacher_id' => 't_000000'.rand(0,9),
                'title' => $this->RandomString(),
                'level' => rand(1,3),
                'wrote_date' => '2016-03-27',
                'content' => $this->RandomString()." ".$this->RandomString()     
            ]);
            DB::table('classlectureregister')->insert([
                'id' => $i,
                'classname' => '9A1',
                'class_id'	=> '15_9_A_1',
                'notice_date' => $notice_date
            ]);
            DB::table('classlectureregister')->insert([
                'id' => $i,
                'classname' => '9A2',
                'class_id'	=> '15_9_A_2',
                'notice_date' => $notice_date
            ]);
    	}
    }

    function RandomString(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            for($k =0; $k <= rand(0,8); $k ++){
                $randstring .= $characters[rand(0, strlen($characters)-1)];
            }
            $randstring .= " ";
        }
        return $randstring;
    }
}
