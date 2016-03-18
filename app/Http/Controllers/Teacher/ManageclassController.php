<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Student;
use App\Model\StudentClass;
use App\User;
use App\Model\Phancong;
use App\Model\Teacher;
use App\Transcript;
use App\Model\Scoretype;
use DB;
use Auth;           

class ManageclassController extends Controller
{
    public function get_view(){
        $year = substr(date("Y"),2);
        $month = date("M");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        $disable = ($class->doable_month == 5) ? "" : "disabled";
        $disable = "";
        $student_list = StudentClass::where('class_id','=',$class->id)->get();
        foreach ($student_list as $key => $student) {
            $student['fullname'] = User::find($student->student_id)->fullname;
            $student['gpa'] = $this->GPA_cal($class->id, $student->student_id);
        }
        $total_student = StudentClass::where('class_id','=',$class->id)->count();
        $year = "20".$year." - 20".$year+1;
        return view('teacherpage.manageclass',['class' => $class, 'student_list' => $student_list,
                                                'year' => $year, 'total_student' => $total_student,
                                                'disable' => $disable
                                                        ]);
    }

    public function GPA_cal($class_id,$student_id){
        $gpa = 0;
        $total_factor = 0;
        $total_score = 0;
        $year = substr($class_id, 0,2);
        $subject_list = Teacher::select('group')
                                ->whereIn('id',
                                            Phancong::select('teacher_id')
                                                    ->where('class_id','=',$class_id)
                                                    ->get()
                                        )
                                ->get();
        $scoretype_list = Scoretype::whereIn('subject_id', $subject_list)
                               ->where('applyfrom','<=',$year)
                               ->where('disablefrom','>=',$year)
                               ->get();
        if(count($scoretype_list) == 0 ){
            $gpa = 0;
        }
        else{
            foreach ($scoretype_list as $key => $scoretype) {
                $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student_id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                if(count($score) == 0){
                    $total_score += 0;
                }
                else{
                    $total_score += $score->score;
                }
                $total_factor += $scoretype->factor;
            }
            $gpa = number_format($total_score/$total_factor,2);
        }
        
        return $gpa;
    }

    public function update(){
        $year = substr(date("Y"),2);
        $month = date("M");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        $student_list = StudentClass::where('class_id','=',$class->id)->get();

        foreach ($student_list as $key => $student) {
            $gpa = $this->GPA_cal($class->id,$student->student_id);
            $ispassed = ($gpa > 5) ? "1" : "0";
            StudentClass::where('class_id','=',$class->id)
                        ->where('student_id','=',$student->student_id)
                        ->update(['GPA' => $gpa, 'ispassed' => $ispassed]);
        }
        return "success";
    }
}
