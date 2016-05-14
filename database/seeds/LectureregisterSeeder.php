<?php

use Illuminate\Database\Seeder;
use App\Model\Classes;

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
            $title = $this->RandomString();
            $content = $this->RandomString()." ".$this->RandomString();
    		DB::table('lectureregister')->insert([
                'teacher_id' => 't_000000'.rand(0,9),
                'title' => $title,
                'level' => rand(1,3),
                'wrote_date' => '2016-03-27',
                'content' => $content
            ]);
            $classes_list = Classes::where('id','like','15_%')->get();
            foreach ($classes_list as $key => $class) {
                DB::table('classlectureregister')->insert([
                    'id' => $i,
                    'classname' => $class->classname,
                    'class_id'  => $class->id,
                    'notice_date' => $notice_date
                ]);
            }
    	}
    }

    private function RandomString(){
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
