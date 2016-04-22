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
            $teacher = Auth::user();
            $year = substr(date('Y'),2,2);
            $month = date('m');
            $year = ($month < 8 ) ? $year - 1 : $year ;
            $tkb = [];
            $check = Phancong::where('teacher_id','=',$teacher->id)
                                 ->where('class_id','like', $year."_%")
                                 ->first();
            if($check == null){
                $data['status'] = "no_schedule";
                return Response::json($data);
            }
            else{
                $check = tkb::all();
                if(count($check) == 0){
                    $data['status'] = "no_schedule";
                    return Response::json($data);
                }
                else{
                    $temp = tkb::where('teacher_id','=',$teacher->id)->first()->toArray();
                    if($temp == null){
                        $data['status'] = "no_schedule";
                        return Response::json($data);
                    }
                    else{
                        //nothing to do
                    }
                    $tkb_date = Sysvar::find('tkb_date')->value;
                    for($i=0;$i<=49;$i++){
                        $tkb['t'.$i] = $temp['T'.$i];
                    }
                    $data['tkb'] = $tkb;
                    $data['status'] = "schedule";
                    $data['date'] = $tkb_date;
                    return Response::json($data);
                }
            }
        }
    }

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
