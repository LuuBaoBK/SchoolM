<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Teacher;
use Auth;
use App\Model\Phancong;
use App\Model\Classes;
use App\Model\Lectureregister;
use App\Model\Classlectureregister;
use App\Model\StudentClass;
use App\Model\tkb;
use App\Model\Student;
use App\Model\Subject;
use App;
class NoticeboardController extends Controller
{
    public function get_view()
    {
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
        $min_date = "20".($year-1)."07-31";
        $notice_list = Classlectureregister::whereIn(
                                                'id',
                                                Lectureregister::where('teacher_id','=',$teacher->id)
                                                                ->where('wrote_date','<=', $min_date)
                                                                ->get()
                                            )->delete();
        $notice_list = Lectureregister::where('teacher_id','=',$teacher->id)
                                      ->where('wrote_date','<=', $min_date)
                                      ->delete();

        $notice_list = Lectureregister::where('teacher_id','=',$teacher->id)
                                      ->where('wrote_date','>', $min_date)
                                      ->orderBy('id','desc')
                                      ->get();
        foreach($notice_list as $key => $notice) {
            $temp_date = date_create($notice->wrote_date);
            $notice->wrote_date = date_format($temp_date,"D d/m/Y");
            $notice->notice_classes;

        }
        // dd($notice_list);
        return view('teacherpage.noticeboard',['class_list' => $class_list, 'notice_list' => $notice_list]);
    }

    public function add_notice(Request $request){
        $isCheck =  $request['next_class'];
        if($isCheck == 'false'){
            $temp = date_create_from_format("D/d/m/Y", $request['notice_date']);
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
            
            foreach ($request['class_list'] as $key => $class) {
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
            return $notice;
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
            
            foreach ($request['class_list'] as $key => $class) {
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
            return $notice;
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

    public function read_notice(Request $request){
        $notice = Lectureregister::find($request['notice_id']);
        foreach ($notice->notice_classes as $key => $class) {
            $temp = $class->notice_date;
            $temp = date_create($temp);
            $notice->notice_classes[$key]->notice_date = date_format($temp,'D d/m/Y');
        }
        $temp_date = date_create_from_format("Y-m-d H:m:s",$notice->wrote_date);
        $temp_date = date_format($temp_date,"D d/m/Y H:m");
        $notice->wrote_date = $temp_date;
        return $notice;
    }
}
