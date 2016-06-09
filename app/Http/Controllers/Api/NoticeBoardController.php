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
use App\Model\Classes;
use App\Model\phancong;
use App\Model\tkb;
use Auth;
use App;

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
                $temp['notice'] = $temp['notice'] = substr(strip_tags($notice->notice_detail->content),0,-1);
                $temp['level'] = $notice->notice_detail->level;
                $temp['deadline'] = $notice->notice_detail->notice_date;
                $temp['title'] = $notice->notice_detail->title;
                $wrote_date = date_create($notice->notice_detail->wrote_date);
                $temp['datewrote'] = date_format($wrote_date,"d/m/Y");
                $temp['author'] = User::find($notice->notice_detail->teacher_id)->fullname;
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
        $data['notice'] = strip_tags($lectureregister->content);
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

    public function get_te_noticeboard(Request $request){
        $return_data = array();
        $return_data['listnotice'] = array();
        $year = substr(date("Y"),2,2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $teacher = Teacher::find(Auth::user()->id);
        $min_date = "20".($year-1)."07-31";
        $notice_list = Lectureregister::where('teacher_id','=',$teacher->id)
                                      ->where('wrote_date','<=', $min_date)
                                      ->delete();

        $notice_list = Lectureregister::where('teacher_id','=',$teacher->id)
                                      ->where('wrote_date','>', $min_date)
                                      ->orderBy('id','desc')
                                      ->take(10)
                                      ->get();
        foreach($notice_list as $key => $notice) {
            $temp['nid'] = $notice->id;
            $temp['subject'] = Subject::find($teacher->group)->subject_name;
            $temp['level'] = $notice->level;
            $temp_date = date_create($notice->wrote_date);
            $temp['deadline'] = date_format($temp_date,"d/m/Y");
            $temp['title'] = substr($notice->title,0,10);
            $temp['content'] = substr(strip_tags($notice->content), 0,30);
            array_push($return_data['listnotice'],$temp);
        }
        return $return_data;
    }

    public function te_read_notice(Request $request){
        $notice = Lectureregister::find($request['length']); // length la nid gui tu android len
        $return_data = array();
        $return_data['listclass'] = array();
        foreach ($notice->notice_classes as $key => $class) {
            $temp_date = $class->notice_date;
            $temp_date = date_create($temp_date);
            $temp['date'] = date_format($temp_date,'d/m/Y');
            $temp['classname'] = $class->classname;
            array_push($return_data['listclass'], $temp);
        }
        $return_data['subject'] = Subject::find(Teacher::find($notice->teacher_id)->group)->subject_name;
        $return_data['content'] = $notice->content;
        $return_data['title'] = $notice->title;
        if($notice->level == "1"){
            $notice->level = "Straightway";
        }
        else if($notice->level == "2"){
            $notice->level = "Gradual";
        }
        else{
            $notice->level = "Behindhand";
        }
        $return_data['level'] = $notice->level."";
        $wrote_date = date_create($notice->wrote_date);
        $return_data['datewrote'] = date_format($wrote_date,"d/m/Y");
        return $return_data;
    }

    public function te_get_classlist(Request $request){
        $return_data['listclass'] = array();
        $year = substr(date("Y"),2,2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $teacher = Teacher::find(Auth::user()->id);
        $class_list = Classes::whereIn( 
                                'id',
                                Phancong::select('class_id')
                                        ->where('teacher_id','=',$teacher->id)
                                        ->where('class_id','like',$year."_%")
                                        ->get()
                              )->get();
        foreach ($class_list as $key => $value) {
            $temp['idclass'] = $value->id;
            $temp['classname'] = $value->classname;
            array_push($return_data['listclass'], $temp);
        }
        return $return_data;
    }

    public function te_create_notice(Request $request){
        $isCheck =  $request['nextday'];
        if($isCheck == 'false'){
            $temp = date_create_from_format("d-m-Y", $request['date']);
            $notice_date = date_format($temp,"Y-m-d");
            $wrote_date = date("Y-m-d H:m:s");
            // $notice = "abc";
            $notice = new Lectureregister;
            $notice->teacher_id = Auth::user()->id;
            $notice->title = $request['title'];
            $notice->level = $request['level'];
            $notice->wrote_date = $wrote_date;
            $notice->content = $request['content'];
            $notice->save();
            $temp_class_list = $request['listclass'];
            $temp_class_list = substr($temp_class_list,0, -1);
            $class_list = explode(",", $temp_class_list);
            $count = 0;
            foreach ($class_list as $key => $class) {
                $count++;
                $class_notice = new Classlectureregister;
                $class_notice->id = $notice->id;
                $class_notice->class_id = $class;
                $class_notice->notice_date = $notice_date;
                $class_notice->classname = Classes::find($class)->classname;
                $class_notice->save();

                $student_list = StudentClass::where('class_id','=',$class)->get();
                $stu_channel = [];
                $pa_channel = [];
                foreach ($student_list as $key => $value) {
                    array_push($stu_channel,$value->student_id.'-channel');
                    array_push($pa_channel,Student::find($value->student_id)->parent->id.'-channel');
                    // $student = Student::find($value->student_id);
                    // $pusher->trigger( $student->parent->id."-chanel",
                    //               'new_notice_event', 
                    //               Auth::user()->id." - ".Auth::user()->fullname." post new notice for ".$student->user->fullname);
                }
                $date_temp = date_create_from_format('Y-m-d',$notice_date);
                $data['nid'] = $notice->id;
                $data['notice_date'] = date_format($date_temp,"d/m/Y");
                $data['show_date'] = date_format($date_temp, "D d/m");
                $data['subject'] = Subject::find(Auth::user()->teacher->group)->subject_name;
                $data['level'] = $notice->level;
                $data['title'] = $notice->title;
                $pusher = App::make('pusher');
                $pusher->trigger( $stu_channel,
                              'new_notice_event', 
                              $data);
                $pusher->trigger( $pa_channel,
                                  'new_notice_event', 
                                  $data);
            }
            return "success";
        }
        else{
            $wrote_date = date("Y-m-d H:m:s");
            $notice = new Lectureregister;
            $notice->teacher_id = Auth::user()->id;
            $notice->title = $request['title'];
            $notice->level = $request['level'];
            $notice->wrote_date = $wrote_date;
            $notice->content = $request['content'];
            $notice->save();
            $temp_class_list = $request['listclass'];
            $temp_class_list = substr($temp_class_list,0, -1);
            $class_list = explode(",", $temp_class_list);
            foreach ($class_list as $key => $class) {
                $classname = Classes::find($class)->classname;
                $teacher_schedule = tkb::where('teacher_id','=',Auth::user()->id)->first();
                $tomorrow_day = $this->my_day_format(date("D", strtotime("+1 day")));
                if($tomorrow_day == 7 || $tomorrow_day == 8){
                    $start = 0;
                }
                else{
                    $start = $tomorrow_day - 2;
                }
                $start = $start*10;
                $found = "false";
                for($i = $start; $i <= 49; $i++){
                    if($teacher_schedule['T'.$i] == $classname){
                        $found = "true";
                        $notice_period = $i;
                        break;
                    }
                }
                if($found == "false"){
                    for($i = 0; $i < $start; $i++){
                        if($teacher_schedule['T'.$i] == $classname){
                            $notice_period = $i;
                            break;
                        }                          
                    }
                    $notice_day = $notice_period/10 - ($notice_period%10)/10;
                    $notice_day += 2;
                }
                else{
                    $notice_day = $notice_period/10 - ($notice_period%10)/10;
                    $notice_day += 2;
                }
                $temp = $notice_day - ($tomorrow_day - 1);
                if($temp <= 0){
                    $temp = $temp + 7;
                }
                $notice_date = date("Y-m-d", strtotime("+".$temp." day"));                

                $class_notice = new Classlectureregister;
                $class_notice->id = $notice->id;
                $class_notice->class_id = $class;
                $class_notice->classname = Classes::find($class)->classname;
                $class_notice->notice_date = $notice_date;
                $class_notice->save();

                $student_list = StudentClass::where('class_id','=',$class)->get();
                $stu_channel = [];
                $pa_channel = [];
                foreach ($student_list as $key => $value) {
                    array_push($stu_channel,$value->student_id.'-channel');
                    array_push($pa_channel,Student::find($value->student_id)->parent->id.'-channel');
                    // $student = Student::find($value->student_id);
                    // $pusher->trigger( $student->parent->id."-chanel",
                    //               'new_notice_event', 
                    //               Auth::user()->id." - ".Auth::user()->fullname." post new notice for ".$student->user->fullname);
                }
                $date_temp = date_create_from_format('Y-m-d',$notice_date);
                $data['nid'] = $notice->id;
                $data['notice_date'] = date_format($date_temp,"d/m/Y");
                $data['show_date'] = date_format($date_temp, "D d/m");
                $data['subject'] = Subject::find(Auth::user()->teacher->group)->subject_name;
                $data['level'] = $notice->level;
                $data['title'] = $notice->title;
                $pusher = App::make('pusher');
                $pusher->trigger( $stu_channel,
                              'new_notice_event', 
                              $data);
                $pusher->trigger( $pa_channel,
                                  'new_notice_event', 
                                  $data);
            }
            return "success";
        }
            
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
