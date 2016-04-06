<?php

namespace App\Http\Controllers\Parents;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Parents;
use App\User;
use App\Model\StudentClass;
use App\Model\Lectureregister;
use App\Model\ClassLectureregister;

class NoticeBoardController extends Controller
{
    public function get_view(){
        $student_list = Parents::find(Auth::user()->id)->student;
        foreach ($student_list as $key => $value) {
            $value->user;
        }
        $notice_list = null;
        return view('parentpage.notice_board', ['notice_list' => $notice_list, 'student_list' => $student_list]);
    }

    public function get_student_noticeboard($student_id){
        $student_list = Parents::find(Auth::user()->id)->student;
        foreach ($student_list as $key => $value) {
            $value->user;
        }

        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $check = StudentClass::where('student_id','=',$student_id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        if($check == null){
            $notice_list = "no_class";
        }
        else{
            $notice_list = [];
            for($i=2; $i<=7; $i++){
                $notice_list[$i] = [];
            }
            $notice_temp_list = ClassLectureregister::where('class_id','=',$check->class_id)->orderBy('id','desc')->get();
            foreach ($notice_temp_list as $key => $notice) {
                $notice_date = date_create($notice->notice_date);
                $notice_day = $this->my_day_format(date_format($notice_date,"D"));
                if($notice_day == 8){
                    $notice_day = 7;
                }
                $notice->notice_detail->notice_date = date_format(date_create($notice->notice_date),"d/m/Y");
                array_push($notice_list[$notice_day], $notice->notice_detail);
            }
        }
        return view('parentpage.notice_board', ['notice_list' => $notice_list, 'student_list' => $student_list, 'student_id' => $student_id]);
    }

    public function read_notice(Request $request){
        $notice = Lectureregister::find($request['notice_id']);
        $notice->wrote_by->user;
        $temp_date = date_create_from_format("Y-m-d H:m:s",$notice->wrote_date);
        $temp_date = date_format($temp_date,"D d/m/Y H:m");
        $notice->wrote_date = $temp_date;
        return $notice;
    }

    private function my_day_format($day){
        if($day == "Mon")
            $day = '2';
        else if($day == "Tue")
            $day = '3';
        else if($day == "Wed")
            $day = '4';
        else if($day === "Thu")
            $day = '5';
        else if($day == "Fri")
            $day = '6';
        else if($day == "Sat")
            $day = '7';
        else
            $day = '8';
        return $day;
    }
}
