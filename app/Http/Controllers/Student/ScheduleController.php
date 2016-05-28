<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\StudentClass;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\Sysvar;
use App\Model\Schedule;
use App\Model\Teacher;
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
            return view('studentpage.schedule',['tkb' => $tkb]);
        }
        else{
            $class = Classes::find($check->class_id);
            $check = Schedule::where('class_id','=',$class->id);
            // $check = tkb::all();
            if(count($check) == 0){
                $tkb =  "no_schedule";
                return view('studentpage.schedule',['tkb' => $tkb]);
            }
            for($i=0;$i<5;$i++){
                for($j=0;$j<10;$j++){
                    if($i==0 && ($j == 0 || $j == 9)){
                        $tiet['subject'] = "Chào cờ";
                    }
                    else if($i==4 && ($j == 4 || $j == 9)){
                        $tiet['subject'] = "Chào cờ";
                    }
                    else{
                        $teacher_id = Schedule::where('day','=',$i+2)
                                                  ->where('period','=',$j)
                                                  ->where('class_id','=',$class->id)
                                                  ->first();
                        if($teacher_id != null){
                            $tiet['subject'] = Teacher::find($teacher_id->teacher_id)->teach->subject_name;
                        }
                        else{
                            $tiet['subject'] = "";
                        }
                        
                    }
                    array_push($tkb,$tiet);
                }
            }
            // for($i = 0; $i<=49; $i++){
            //     if($i == 0 || $i == 9){
            //         $tiet['subject'] = "Chào cờ";
            //     }
            //     else if($i == 44 || $i == 49){
            //         $tiet['subject'] = "SHCD";
            //     }
            //     else{
            //         $temp = tkb::where("T".$i,"=",$class->classname)->first();
            //         if($temp == null){
            //             $tiet['subject'] = "";
            //         }
            //         else{
            //             $tiet['subject'] = $temp->subject_name;
            //         }
            //     }
            //     array_push($tkb,$tiet);
            // }
            // dd($tkb);
            $tkb_date = Sysvar::find('tkb_date')->value;
            return view('studentpage.schedule',['tkb' => $tkb, 'tkb_date' => $tkb_date, 'class' => $class]);
        }
    }
}
