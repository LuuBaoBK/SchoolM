<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Student;
use App\Model\StudentClass;
use App\User;
use App\Model\Phancong;
use App\Model\Teacher;
use App\Transcript;
use App\Model\Scoretype;
use App\Model\Schedule;
use App\Model\Subject;
use DB;
use Auth;           
use App\Model\Messages;
use App\Model\MsgSend;
use App\Model\MsgRecv;
use App;

class ManageclassController extends Controller
{
    public function get_view(){
        $year = substr(date("Y"),2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        $disable = "";

        if($class == null){
            return view('teacherpage.manageclass', ['class' => $class]);
        }
         
        $student_list = StudentClass::where('class_id','=',$class->id)->get();
        foreach ($student_list as $key => $student) {
            $student['fullname'] = User::find($student->student_id)->fullname;
            // $student['gpa'] = $this->GPA_cal($class->id, $student->student_id);
        }
        $total_student = StudentClass::where('class_id','=',$class->id)->count();
        $year = "20".$year." - 20".($year+1);
        // dd($student_list);
        return view('teacherpage.manageclass',['class' => $class, 'student_list' => $student_list,
                                                'year' => $year, 'total_student' => $total_student,
                                                'disable' => $disable
                                                        ]);
    }

    public function GPA_cal($class_id,$student_id){
        $gpa_hk1 = 0;
        $gpa_hk2 = 0;
        $gpa = 0;
        $year = substr($class_id, 0,2);

        $subject_id_list = Subject::select('id')->get();
        $total_subject =count($subject_id_list);
        foreach ($subject_id_list as $subject) {
            //tinh diem hk 1 cua tung mon
            $scoretype_list = Scoretype::where('subject_id','=',$subject->id)
                                       ->where('applyfrom','<=',$year)
                                       ->where('disablefrom','>=',$year)
                                       ->where('month','>=', 8)
                                       ->get();
            $temp_gpa = 0;
            $temp_factor = 0;
            foreach ($scoretype_list as $scoretype) {
                $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student_id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                if($score == null){
                    $temp_factor += $scoretype->factor;
                    $temp_gpa += 0;
                }
                else{
                    $score->score = ($score->score > 10) ? 0 : $score->score;
                    $temp_factor += $scoretype->factor;
                    $temp_gpa += $score->score * $scoretype->factor;                    
                }
            }
            $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
            $gpa_hk1 += $temp_gpa;

            // hk 2
            $scoretype_list = Scoretype::where('subject_id','=',$subject->id)
                                       ->where('applyfrom','<=',$year)
                                       ->where('disablefrom','>=',$year)
                                       ->where('month','<', 8)
                                       ->get();
            $temp_gpa = 0;
            $temp_factor = 0;
            foreach ($scoretype_list as $scoretype) {
                $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student_id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                if($score == null){
                    $temp_factor += $scoretype->factor;
                    $temp_gpa += 0;
                }
                else{
                    $score->score = ($score->score > 10) ? 0 : $score->score;
                    $temp_factor += $scoretype->factor;
                    $temp_gpa += $score->score * $scoretype->factor;                    
                }
            }
            $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
            $gpa_hk2 += $temp_gpa;
        }
        $gpa_hk1 = number_format(($gpa_hk1/$total_subject),2);
        $gpa_hk2 = number_format(($gpa_hk2/$total_subject),2);
        $gpa = number_format(($gpa_hk1 + 2*$gpa_hk2 )/ 3,2);
        $gpa = round( $gpa, 1, PHP_ROUND_HALF_UP);

        return $gpa;
    }

    public function update(){
        $year = substr(date("Y"),2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        $grade = explode("_",$class->id);
        $student_list = StudentClass::where('class_id','=',$class->id)->get();

        foreach ($student_list as $key => $student) {
            $gpa = $this->GPA_cal($class->id,$student->student_id);
            $ispassed = ($gpa > 5) ? "1" : "0";
            StudentClass::where('class_id','=',$class->id)
                        ->where('student_id','=',$student->student_id)
                        ->update(['GPA' => $gpa, 'ispassed' => $ispassed]);
            if($grade[1] == 9){
                if($ispassed == 1){
                    Student::find($student->student_id)->update(['graduated_year' => "20".($year+1)]);
                }
            }
        }
        return "success";
    }

    public function set_conduct(Request $request){
        $Id_list = $request['Idlist'];
        $year = substr(date("Y"),2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        StudentClass::where('class_id','=',$class->id)
                    ->whereIn('student_id',$Id_list)
                    ->update(['conduct' => $request['conduct']]);
        return "success";
    }

    public function add_note(Request $request){
        $Id_list = $request['Idlist'];
        $year = substr(date("Y"),2);
        $month = date("m");
        $year = ($month < 8) ? $year - 1 : $year;
        $class = Classes::where('homeroom_teacher','=',Auth::user()->id)
                        ->where('id','like',$year."_%")
                        ->first();
        StudentClass::where('class_id','=',$class->id)
                    ->whereIn('student_id',$Id_list)
                    ->update(['note' => $request['note_add']]);
        return "success";
    }

    public function create_report_1($class_id){
        $report = $this->make_report_1($class_id);
        $subject = Subject::orderBy('subject_name','asc')->get();
        $class = Classes::find($class_id);
        // dd($report);
        return view('teacherpage.report.report_hk_i',['student_list' => $report,
                                                      'subject_list' => $subject,
                                                      'class' => $class,
                                                      ]);
    }

    private function make_report_1($class_id){
        $year = substr($class_id,0,2);
        $student_list = StudentClass::select('student_id')->where('class_id','=',$class_id)->get();
        $student_list = User::whereIn('id',$student_list)->orderBy('lastname','asc')->orderBy('middlename','asc')->orderBy('firstname','asc')->get();
        $subject_list = Subject::all();
        $total_subject = count($subject_list);
        $return_stu_list = array();
        foreach ($subject_list as $key => $value) {
            $value->score_type;
        }
        foreach ($student_list as $key => $student) {
            $score_list = [];
            $gpa_hk1 = 0;
            foreach ($subject_list as $subject) {
                $temp_factor = 0;
                $temp_gpa = 0;
                foreach ($subject->score_type()
                        ->where('applyfrom','<=',$year)
                        ->where('applyfrom','<=',$year)
                        ->where('disablefrom','>=',$year)
                        ->where('month','>=', 8)
                        ->get() as $scoretype)
                {
                    $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student->id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                    if($score == null){
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += 0;
                    }
                    else{
                        $score->score = ($score->score > 10) ? 0 : $score->score;
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += $score->score * $scoretype->factor;                    
                    }
                }
                $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
                $temp[$subject->id] = $temp_gpa; 
                $gpa_hk1 += $temp_gpa; 
            }
            $gpa_hk1 = number_format(($gpa_hk1/$total_subject),2);
            $gpa_hk1 = round( $gpa_hk1, 1, PHP_ROUND_HALF_UP);
            $temp['tb_hk1'] = $gpa_hk1;
            if($gpa_hk1 > 8){
                $performance = "Excellent";
            }
            else if($gpa_hk1 > 6.5){
                $performance = "Good";
            }
            else if($gpa_hk1 > 5){
                $performance = "Avarage";
            }
            else{
                $performance = "Bad";
            }
            array_push($score_list, $temp);
            $return_stu_list[$key]['score_list'] = $score_list;
            $return_stu_list[$key]['fullname'] = $student->fullname;
            $return_stu_list[$key]['id'] = $student->id;
            $return_stu_list[$key]['performance'] = $performance;
        }
        usort($return_stu_list, array($this,"cmp"));
        return $return_stu_list;
    }

    public function create_report_2($class_id){
        $report = $this->make_report_2($class_id);
        $subject = Subject::orderBy('subject_name','asc')->get();
        $class = Classes::find($class_id);
        // dd($report);
        return view('teacherpage.report.report_hk_ii',['student_list' => $report,
                                                      'subject_list' => $subject,
                                                      'class' => $class,
                                                      ]);
    }

    private function make_report_2($class_id){
        $year = substr($class_id,0,2);
        $student_list = StudentClass::select('student_id')->where('class_id','=',$class_id)->get();
        $student_list = User::whereIn('id',$student_list)->orderBy('lastname','asc')->orderBy('middlename','asc')->orderBy('firstname','asc')->get();
        $subject_list = Subject::all();
        $total_subject = count($subject_list);
        $return_stu_list = array();
        foreach ($subject_list as $key => $value) {
            $value->score_type;
        }
        foreach ($student_list as $key => $student) {
            $score_list = [];
            $gpa_hk1 = 0;
            foreach ($subject_list as $subject) {
                $temp_factor = 0;
                $temp_gpa = 0;
                foreach ($subject->score_type()
                        ->where('applyfrom','<=',$year)
                        ->where('applyfrom','<=',$year)
                        ->where('disablefrom','>=',$year)
                        ->where('month','<', 8)
                        ->get() as $scoretype)
                {
                    $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student->id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                    if($score == null){
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += 0;
                    }
                    else{
                        $score->score = ($score->score > 10) ? 0 : $score->score;
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += $score->score * $scoretype->factor;                    
                    }
                }
                $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
                $temp[$subject->id] = $temp_gpa; 
                $gpa_hk1 += $temp_gpa; 
            }
            $gpa_hk1 = number_format(($gpa_hk1/$total_subject),2);
            $gpa_hk1 = round( $gpa_hk1, 1, PHP_ROUND_HALF_UP);
            if($gpa_hk1 > 8){
                $performance = "Excellent";
            }
            else if($gpa_hk1 > 6.5){
                $performance = "Good";
            }
            else if($gpa_hk1 > 5){
                $performance = "Avarage";
            }
            else{
                $performance = "Bad";
            }
            $temp['tb_hk1'] = $gpa_hk1;
            array_push($score_list, $temp);
            $return_stu_list[$key]['score_list'] = $score_list;
            $return_stu_list[$key]['fullname'] = $student->fullname;
            $return_stu_list[$key]['id'] = $student->id;
            $return_stu_list[$key]['performance'] = $performance;
        }
        usort($return_stu_list, array($this,"cmp"));
        return $return_stu_list;
    }

    public function create_report_3($class_id){
        $report = $this->make_report_3($class_id);
        $subject = Subject::orderBy('subject_name','asc')->get();
        $class = Classes::find($class_id);
        // dd($report);
        return view('teacherpage.report.report_year',['student_list' => $report,
                                                      'subject_list' => $subject,
                                                      'class' => $class,
                                                      ]);
    }

    private function make_report_3($class_id){
        $year = substr($class_id,0,2);
        $student_list = StudentClass::select('student_id')->where('class_id','=',$class_id)->get();
        $student_list = User::whereIn('id',$student_list)->orderBy('lastname','asc')->orderBy('middlename','asc')->orderBy('firstname','asc')->get();
        $subject_list = Subject::all();
        $total_subject = count($subject_list);
        $return_stu_list = array();
        foreach ($subject_list as $key => $value) {
            $value->score_type;
        }
        foreach ($student_list as $key => $student) {
            $score_list = [];
            $gpa_hk1 = 0;
            $gpa_hk2 = 0;
            foreach ($subject_list as $subject) {
                $temp_factor = 0;
                $temp_gpa = 0;
                foreach ($subject->score_type()
                        ->where('applyfrom','<=',$year)
                        ->where('applyfrom','<=',$year)
                        ->where('disablefrom','>=',$year)
                        ->where('month','>=', 8)
                        ->get() as $scoretype)
                {
                    $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student->id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                    if($score == null){
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += 0;
                    }
                    else{
                        $score->score = ($score->score > 10) ? 0 : $score->score;
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += $score->score * $scoretype->factor;                    
                    }
                }
                $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
                $temp[$subject->id] = $temp_gpa; 
                $gpa_hk1 += $temp_gpa; 

                $temp_factor = 0;
                $temp_gpa = 0;
                foreach ($subject->score_type()
                        ->where('applyfrom','<=',$year)
                        ->where('applyfrom','<=',$year)
                        ->where('disablefrom','>=',$year)
                        ->where('month','<', 8)
                        ->get() as $scoretype)
                {
                    $score = Transcript::where('scoretype_id','=',$scoretype->id)
                                    ->where('student_id','=',$student->id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                    if($score == null){
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += 0;
                    }
                    else{
                        $score->score = ($score->score > 10) ? 0 : $score->score;
                        $temp_factor += $scoretype->factor;
                        $temp_gpa += $score->score * $scoretype->factor;                    
                    }
                }
                $temp_gpa = number_format(($temp_gpa / $temp_factor), 2 );
                $temp[$subject->id] = round(number_format(($temp[$subject->id]+ 2*$temp_gpa )/ 3,2),1,PHP_ROUND_HALF_UP); 
                $gpa_hk2 += $temp_gpa; 
            }
            $gpa_hk1 = number_format(($gpa_hk1/$total_subject),2);
            $gpa_hk1 = round( $gpa_hk1, 1, PHP_ROUND_HALF_UP);
            $gpa_hk2 = number_format(($gpa_hk2/$total_subject),2);
            $gpa_hk2 = round( $gpa_hk2, 1, PHP_ROUND_HALF_UP);
            $gpa_nam = round( number_format(($gpa_hk1+2*$gpa_hk2)/3,2), 1, PHP_ROUND_HALF_UP);
            if($gpa_nam > 8){
                $performance = "Excellent";
            }
            else if($gpa_nam > 6.5){
                $performance = "Good";
            }
            else if($gpa_nam > 5){
                $performance = "Avarage";
            }
            else{
                $performance = "Bad";
            }
            $temp['tb_hk1'] = $gpa_hk1;
            $temp['tb_hk2'] = $gpa_hk2;
            $temp['tb_nam'] = $gpa_nam;
            array_push($score_list, $temp);

            $return_stu_list[$key]['score_list'] = $score_list;
            $return_stu_list[$key]['fullname'] = $student->fullname;
            $return_stu_list[$key]['id'] = $student->id;
            $return_stu_list[$key]['performance'] = $performance;
        }
        usort($return_stu_list, array($this,"cmp2"));
        return $return_stu_list;
    }

    private function cmp($a, $b){
        return strcmp($b['score_list'][0]['tb_hk1'], $a['score_list'][0]['tb_hk1']);
    }
    private function cmp2($a, $b){
        return strcmp($b['score_list'][0]['tb_nam'], $a['score_list'][0]['tb_nam']);
    }

    public function send_report(Request $request){
        //receive data from serve
        $student_list = $request['studentlist'];
        $header_list = $request['header'];
        $report_type = $request['type'];
        $user = Auth::user();
        //send data
        $parent_list = [];
        foreach ($student_list as $key => $student) {
            //prepare data for each parent
            $parent = Student::find($student[0])->parent->id;
            array_push($parent_list,$parent."-channel");
            // $data_send = "<b>".$report_type."<b> <br/>";
            $data_send = "<b>".$student[1]."<b> <br/>";
            for($i=2; $i<= (count($header_list)-1); $i++){
                $data_send .= "<b>".$header_list[$i]."</b>: ".$student[$i]." <br/>";
            }
            //create Message
            $message = new Messages;
            $message->content = $data_send;
            $message->title = $report_type;
            $message->created_at = date('Y-m-d H:i:s');
            $message->save();
            $msg_recv = new MsgRecv;
            $msg_recv->recvby = $parent;
            $msg_recv->isdelete = 0;
            $msg_recv->isread = 0;
            $msg_recv->id = $message->id;
            $msg_recv->save();
            $msg_send = new MsgSend;
            $msg_send->id = $message->id;
            $msg_send->sendby = $user->id;
            $msg_send->isdelete = 0;
            $msg_send->isdraft = 0;  
            $msg_send->save();
        }
        // trigger event on pusher
        $pusher = App::make('pusher');
        $pusher->trigger( $parent_list,
                      'new_mail_event', 
                      $user->id."-".$user->fullname);
        return $parent_list;
    }
}
