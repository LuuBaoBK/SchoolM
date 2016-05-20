<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Student;
use App\Model\Classlectureregister;
use App\Model\Lectureregister;
use App\Model\StudentClass;
use App\Model\Subject;
use App\Model\Teacher;
use Auth;

class NoticeBoardController extends Controller
{
    public function get_stu_noticeboard(Request $request){
        $day = $request['data'];
        $day = $day + 2;
        $student = Auth::user();
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $check = StudentClass::where('student_id','=',$student->id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        $notice_list = array();
        $notice_list['status'] = null;
        $notice_list['listnotice'] = array();
        if($check == null){
            $notice_list['status'] = "no_class";
        }
        else{
            $notice_list['status'] = "success";
            $to_day = date('D');
            $to_day = $this->my_day_format($to_day);
            if($to_day == 8)
                $to_day = 7;
            $offset = (($day - $to_day) < 0) ? ($day - $to_day +7) : ($day - $to_day);
            $date = date('Y-m-d 00:00:00', strtotime("+".$offset." day"));
            if($day == 7){
                $offset += 1;
                $plus = date('Y-m-d 00:00:00', strtotime("+".$offset." day"));
                $notice_temp_list = Classlectureregister::where('class_id','=',$check->class_id)
                                                        ->where('notice_date','=',$date)
                                                        ->orWhere('notice_date','=',$plus)
                                                        ->orderBy('id','desc')->get();
            }
            else{
                $notice_temp_list = Classlectureregister::where('class_id','=',$check->class_id)
                                                        ->where('notice_date','=',$date)    
                                                        ->orderBy('id','desc')->get();
            }
            $temp = array();
            foreach ($notice_temp_list as $key => $notice) {
                $notice_date = date_create($notice->notice_date);
                $notice_day = $this->my_day_format(date_format($notice_date,"D"));
                if($notice_day == 8){
                    $notice_day = 7;
                }
                $notice->notice_detail->notice_date = date_format(date_create($notice->notice_date),"d/m/Y");
                $notice->notice_detail->subject = Subject::find($notice->notice_detail->wrote_by->group)->subject_name;
                $temp['nid'] = $notice->notice_detail->id;
                $temp['subject'] = $notice->notice_detail->subject;
                $temp['notice'] = $notice->notice_detail->title;
                $temp['level'] = $notice->notice_detail->level;
                $temp['deadline'] = $notice->notice_detail->notice_date;
                array_push($notice_list['listnotice'], $temp);
            }
        }
        return $notice_list;
    }

    public function get_pa_noticeboard(Request $request){
        $day = $request['data'];
        $day = $day + 2;
        $student = User::find($request['id']);
        $year = substr(date('Y'),2,2);
        $month = date('m');
        $year = ($month < 8 ) ? $year - 1 : $year ;
        $check = StudentClass::where('student_id','=',$student->id)
                             ->where('class_id','like', $year."_%")
                             ->first();
        $notice_list = array();
        $notice_list['status'] = null;
        $notice_list['listnotice'] = array();
        if($check == null){
            $notice_list['status'] = "no_class";
        }
        else{
            $notice_list['status'] = "success";
            $to_day = date('D');
            $to_day = $this->my_day_format($to_day);
            if($to_day == 8)
                $to_day = 7;
            $offset = (($day - $to_day) < 0) ? ($day - $to_day +7) : ($day - $to_day);
            $date = date('Y-m-d 00:00:00', strtotime("+".$offset." day"));
            if($day == 7){
                $offset += 1;
                $plus = date('Y-m-d 00:00:00', strtotime("+".$offset." day"));
                $notice_temp_list = Classlectureregister::where('class_id','=',$check->class_id)
                                                        ->where('notice_date','=',$date)
                                                        ->orWhere('notice_date','=',$plus)
                                                        ->orderBy('id','desc')->get();
            }
            else{
                $notice_temp_list = Classlectureregister::where('class_id','=',$check->class_id)
                                                        ->where('notice_date','=',$date)    
                                                        ->orderBy('id','desc')->get();
            }
            $temp = array();
            foreach ($notice_temp_list as $key => $notice) {
                $notice_date = date_create($notice->notice_date);
                $notice_day = $this->my_day_format(date_format($notice_date,"D"));
                if($notice_day == 8){
                    $notice_day = 7;
                }
                $notice->notice_detail->notice_date = date_format(date_create($notice->notice_date),"d/m/Y");
                $notice->notice_detail->subject = Subject::find($notice->notice_detail->wrote_by->group)->subject_name;
                $temp['nid'] = $notice->notice_detail->id;
                $temp['subject'] = $notice->notice_detail->subject;
                $temp['notice'] = $notice->notice_detail->title;
                $temp['level'] = $notice->notice_detail->level;
                $temp['deadline'] = $notice->notice_detail->notice_date;
                array_push($notice_list['listnotice'], $temp);
            }
        }
        return $notice_list;
    }

    public function get_notice_detail(Request $request){
        $nid = $request['data'];
        $child_id = $request['child'];
        $lectureregister = Lectureregister::find($nid);
        $author = Teacher::find($lectureregister->teacher_id);
        //subject author ngaytao level deadline content
        $data['subject'] = Subject::find($author->group)->subject_name;
        $data['author'] = $author->user->fullname;
        $data['ngaytao'] = date_format(date_create($lectureregister->wrote_date),'d/m/Y');
        $data['level'] = $lectureregister->level;
        $data['notice'] = $lectureregister->content;
        $data['title'] = $lectureregister->title;
        if($child_id == "self"){
            $student = Auth::user();
        }
        else{
            $student = User::find($child_id);
        }
        $year = substr(date("Y"),2,2);
        $year = (date("m") < 8) ? ($year-1) : $year;
        $class = StudentClass::where('class_id','like',$year."%")->where('student_id','=',$student->id)->first();
        $temp = Classlectureregister::where('id','=',$nid)->where('class_id','=',$class->class_id)->first();
        $data['deadline'] = date_format(date_create($temp->notice_date),'d/m/Y');
        return $data;
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
