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

class ScheduleController extends Controller
{
    public function get_view(){
        $teacher = Auth::user();
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $tkb = [];
        $check = Phancong::where('teacher_id','=',$teacher->id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        if($check == null){
            $tkb = "no_placement";
            return view('teacherpage.schedule',['tkb' => $tkb]);
        }
        else{
            $check = tkb::all();
            if(count($check) == 0){
                $tkb = "no_schedule";
                return view('teacherpage.schedule',['tkb' => $tkb]);
            }
            else{
                $tkb = tkb::where('teacher_id','=',$teacher->id)->first()->toArray();
                if($tkb == null){
                    $tkb = "no_schedule";
                    return view('teacherpage.schedule',['tkb' => $tkb]);
                }
                else{
                }
                $tkb_date = Sysvar::find('tkb_date')->value;
                return view('teacherpage.schedule',['tkb' => $tkb, 'tkb_date' => $tkb_date]);
            }
        }
    }
}
