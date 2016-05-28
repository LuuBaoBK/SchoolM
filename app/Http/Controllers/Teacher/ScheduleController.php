<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\StudentClass;
use App\Model\Teacher;
use App\Model\tkb;
use App\Model\Phancong;
use App\Model\Classes;
use App\Model\Sysvar;
use App\Model\Schedule;

class ScheduleController extends Controller
{
    public function get_view(){
        $teacher = Auth::user();
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $tkb = [];
        // $check = Phancong::where('teacher_id','=',$teacher->id)
        //                      ->where('class_id','like', $year."_%")
        //                      ->first();
        $check = Schedule::where('teacher_id','=',$teacher->id)
                         ->where('class_id','like',$year."%")
                         ->first();
        if($check == null){
            $tkb = "no_placement";
            return view('teacherpage.schedule',['tkb' => $tkb]);
        }
        else{
            $tkb = [];
            for($i=0;$i<5;$i++){
                for($j=0;$j<10;$j++){
                    $temp = Schedule::where('teacher_id','=',$teacher->id)
                                    ->where('period','=',$j)
                                    ->where('day','=',$i+2)
                                    ->first();
                    if($temp != null){
                        $temp =array_push($tkb, substr(str_replace("_", "", $temp->class_id), 2));
                    }
                    else{
                        array_push($tkb, "");
                    }
                }
            }
            if($tkb == null){
                $tkb = "no_schedule";
                return view('teacherpage.schedule',['tkb' => $tkb]);
            }
            else{
                // do no thing
            }
            $tkb_date = Sysvar::find('tkb_date')->value;
            return view('teacherpage.schedule',['tkb' => $tkb, 'tkb_date' => $tkb_date]);
        }
    }
}
