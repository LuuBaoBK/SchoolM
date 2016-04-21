<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Response;
use Auth;

use App\Model\tkb;
use App\Model\StudentClass;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\Sysvar;

class MobileScheduleController extends ApiGuardController
{
    public function get_schedule(){
        $user = Auth::user();
        $tkb = [];
        if($user->role == 0 || $user->role == 3){
            $data['status'] = "no_schedule";
            return Response::json($data);
        }
        else{
            $data['status'] = "schedule";
        }
        $data['status'] = "schedule";
        if($user->role == 2){
            $student = Auth::user();
            $year = substr(date('Y'),2,2);
            $month = date('m');
            $year = ($month < 8 ) ? $year - 1 : $year ;
            $check = StudentClass::where('student_id','=',$student->id)
                             ->where('class_id','like', $year."_%")
                             ->first();
            if($check == null){
                $data['status'] = "no_schedule";
                return Response::json($data);
            }
            else{
                $class = Classes::find($check->class_id);
                $teacher_list = Phancong::select('teacher_id')->where('class_id','=',$class->id)->get();
                if(count($teacher_list) == 0){
                    $data['status'] = "no_schedule";
                    return Response::json($data);
                }
                else{
                    $check = tkb::all();
                    if(count($check) == 0){
                        $data['status'] = "no_schedule";
                        return Response::json($data);
                    }
                    for($i = 0; $i<=49; $i++){
                        if($i == 0 || $i == 9){
                            $tkb['t'.$i] = "Chào Cờ";
                        }
                        else if($i == 44 || $i == 49){
                            $tkb['t'.$i] = "SHCN";
                        }
                        else{
                            $tiet = tkb::select('subject_name')
                                  ->whereIn('teacher_id',$teacher_list)
                                  ->where('T'.$i,'=',$class->classname)->first();
                            if($tiet == null){
                                $tkb['t'.$i] = "";
                            }
                            else{
                                $tkb['t'.$i] = $tiet->subject_name;
                            }
                        }
                    }
                    $tkb_date = Sysvar::find('tkb_date')->value;
                    $data['date'] = $tkb_date;
                    $data['tkb'] = $tkb;
                    return Response::json($data);
                }
            }
            //
        }
        else if($user->role == 1){
            $tkb['user'] = $user->id;
        }
    }

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
            $teacher_list = Phancong::select('teacher_id')->where('class_id','=',$class->id)->get();
            if(count($teacher_list) == 0){
                $tkb =  "no_schedule";
                return view('studentpage.schedule',['tkb' => $tkb]);
            }
            else{
                $check = tkb::all();
                if(count($check) == 0){
                    $tkb =  "no_schedule";
                    return view('studentpage.schedule',['tkb' => $tkb]);
                }
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
                return view('studentpage.schedule',['tkb' => $tkb, 'tkb_date' => $tkb_date, 'class' => $class]);
            }
        }
    }
}
