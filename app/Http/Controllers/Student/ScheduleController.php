<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\tkb;
use App\Model\StudentClass;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\Sysvar;
use Auth;

class ScheduleController extends Controller
{
    public function get_view(){
        $student = Auth::user();
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $tkb = [];
        $check = StudentClass::where('student_id','=',$student->id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        if($check == null){
            $tkb = "no_class";
        }
        else{
            $class = Classes::find($check->class_id);
            $teacher_list = Phancong::select('teacher_id')->where('class_id','=',$class->id)->get();
            if(count($teacher_list) == 0){
                $tkb =  "no_schedule";
            }
            else{
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
                $tkb_date = Sysvar::find('tkb_date')->value;
                //dd($tkb);
            }
        }
        return view('studentpage.schedule',['tkb' => $tkb, 'tkb_date' => $tkb_date, 'class' => $class]);
    }
}
