<?php

namespace App\Http\Controllers\Parents;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Student;
use App\Model\Parents;
use App\Model\Sysvar;
use App\Model\StudentClass;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\tkb;
use App\User;

class ScheduleController extends Controller
{
    public function get_view(){
        $student_list = Parents::find(Auth::user()->id)->student;
        if(count($student_list) == 1){
            return redirect('parents/schedule/student_schedule/'.$student_list[0]->user->id);
        }
        foreach ($student_list as $key => $value) {
            $value->user;
        } 
        $tkb = "select_student";
        $updatetime = "No Student Selected";
        return view('parentpage.Schedule', ['tkb' => $tkb, 'student_list' => $student_list, 'updatetime' => $updatetime]);
    }

    public function show_student_schedule($student_id){
        $student_list = Parents::find(Auth::user()->id)->student;
        foreach ($student_list as $key => $value) {
            $value->user;
        } 
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $tkb = [];
        $check = StudentClass::where('student_id','=',$student_id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        if($check == null){
            $tkb = "no_class";
        }
        else{
            $class = Classes::find($check->class_id);
            $student_name = User::find($student_id)->fullname;
            $teacher_list = Phancong::select('teacher_id')->where('class_id','=',$class->id)->get();
            if(count($teacher_list) == 0){
                $tkb =  "no_schedule";
            }
            else{
                $check = tkb::all();
                if(count($check) == 0){
                    $tkb =  "no_schedule";                }
                for($i = 0; $i<=49; $i++){
                    if($i == 0 || $i == 9){
                        $tiet['subject'] = "Chào Cờ";
                    }
                    else if($i == 44 || $i == 49){
                        $tiet['subject'] = "SHCN";
                    }
                    else{
                        $tiet = tkb::select('subject_name')
                              ->whereIn('teacher_id',$teacher_list)
                              ->where('T'.$i,'=',$class->classname)->first();
                        if($tiet == null){
                            $tiet['subject'] = "";
                        }
                        else{
                            $tiet['subject'] = $tiet->subject_name;
                        }
                    }
                    array_push($tkb, $tiet);
                }
            }
        }
        $updatetime = Sysvar::find('tkb_date')->value;
        return view('parentpage.Schedule', ['tkb' => $tkb, 'student_list' => $student_list, 'updatetime' => $updatetime, 'class' => $class, 'student_name' => $student_name]);
    }
}
