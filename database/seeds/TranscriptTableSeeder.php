<?php

use Illuminate\Database\Seeder;
use App\Transcript;
use App\Model\Scoretype;
use App\Model\StudentClass;
use App\Model\Teacher;
use App\Model\Classes;
use App\Model\Subject;

class TranscriptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//all subject
    	$subject_list = Subject::all();
    	foreach ($subject_list as $key => $subject) {
    		//all scoretype
    		$scoretype_list = Scoretype::where('subject_id','=',$subject->id)->get();
    		foreach ($scoretype_list as $key => $scoretype) {
    			// all class 2014-2015
    			$student_list = StudentClass::where('class_id','like','14_%')->get();
    			foreach ($student_list as $key => $student) {
    				$new_row = new Transcript;
    				$new_row->scholastic = '14';
    				$new_row->student_id = $student->student_id;
    				$new_row->subject_id = $subject->id;
    				$new_row->scoretype_id = $scoretype->id;
    				$new_row->score = rand(5,10);
    				$new_row->note = "";
    				$new_row->save();
    			}

    			$student_list = StudentClass::where('class_id','like','15_%')->get();
    			foreach ($student_list as $key => $student) {
    				$new_row = new Transcript;
    				$new_row->scholastic = '15';
    				$new_row->student_id = $student->student_id;
    				$new_row->subject_id = $subject->id;
    				$new_row->scoretype_id = $scoretype->id;
    				$new_row->score = rand(1,10);
    				$new_row->note = "";
    				$new_row->save();
    			}
    		}
    	}
    }
}
