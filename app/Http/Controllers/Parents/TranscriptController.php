<?php

namespace App\Http\Controllers\Parents;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Parents;
use App\Model\Classes;
use App\Model\StudentClass;
use App\User;
use App\Model\Student;
use App\Model\Phancong;
use App\Model\Teacher;
use App\Model\Subject;
use App\Transcript;
use App\Model\Scoretype;
use App\Model\Schedule;
use DB;

class TranscriptController extends Controller
{
    public function get_view()
    {
        $student_list = Parents::find(Auth::user()->id)->student;
        if(count($student_list) == 1){
            return redirect('parents/transcript/student_transcript/'.$student_list[0]->user->id);
        }
        foreach ($student_list as $key => $value) {
            $value->user;
        } 
        $class_list = null;
        $student_choose = null;
        return view('parentpage.transcript', ['student_list' => $student_list, 'class_list' => $class_list, 'student_choose' => $student_choose]);
    }

    public function show_student_transcript($student_id)
    {
        $student_list = Parents::find(Auth::user()->id)->student;
        foreach ($student_list as $key => $value) {
            $value->user;
        } 

        $student = Student::find($student_id);
        $class_list = Classes::whereIn('id',StudentClass::select('class_id')->where('student_id','=',$student->id)->get())->get();
        foreach ($class_list as $key => $class) {
            $class['home_teacher'] = User::find($class->homeroom_teacher);
        }
        $student_choose = $student_id;
        return view('parentpage.transcript', ['student_list' => $student_list, 'class_list' => $class_list, 'student_choose' => $student_choose]);
    }

    public function select_class(Request $request)
    {
        $class_id = $request['data'][0];
        $year = substr($class_id, 0, 2);
        $tb = [];
        $student = StudentClass::where('class_id','=',$class_id)->where('student_id','=',$request['student_id'])->first();
        $phancong = Phancong::where('class_id','=',$class_id)->get();
        foreach ($phancong as $key => $row) {
            $row['teacher_name'] = User::find($row->teacher_id)->fullname;
            $row['subject'] = Subject::find(Teacher::find($row->teacher_id)->group);
          $row['class_id'] = $class_id;
        }
        //HK 1 
        if(count($phancong) == 0){
          $phancong = Subject::all();
          foreach ($phancong as $key => $row) {
            $row['teacher_name'] = "_";
            $row['subject'] = Subject::find($row->id);
            $row['class_id'] = $class_id;
          }
        }

        $record['0'] = $phancong;
        $record['1'] = $this->cal_summary_score($class_id,$request['student_id']);
        $record['2'] = $student;
        return $record;

    }

    public function select_subject(Request $request){
      $record = [];
      $student_id = $request['student_id'];
      $class_id = $request['data'][1];
      $year = substr($class_id, 0,2);
      if($request['data'][0] == "all"){
        $record['type'] = 'all';
        $record['data'] = $this->cal_summary_score($class_id,$student_id);
        return $record;
      }
      else{
        $hk1_average = 0;
        $hk2_average = 0;
        $hk1_total_factor = 0;
        $hk2_total_factor = 0;
        for($i=8;$i<=12;$i++){
          $month_score = [];
          $month_average = 0;
          $month_total_factor = 0;
          $scoretype_month = Scoretype::where('subject_id','=',$request['data'][0])
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',$student_id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $month_score[$score->type][0] = ($temp->score > 10) ? 0 : $temp->score;
                $month_score[$score->type][1] = $temp->note;
                $month_average += $month_score[$score->type][0] * $score->factor;
                $month_total_factor += $score->factor;
                $hk1_average += $month_score[$score->type][0] * $score->factor;
                $hk1_total_factor += $score->factor;
              }
              else{
                $month_score[$score->type][0] = "missing";
                $month_total_factor += $score->factor;
                $hk1_average += 0;
                $hk1_total_factor += $score->factor;
              }
            }

            $month_average = number_format(($month_average / $month_total_factor) , 2);
            $month_score['month_'.$i.'_average'] = $month_average;
          }
          else{
            $month_score['month_'.$i.'_average'] = 'noscore';
          }
          
          $record['month_'.$i] = $month_score;
        }
        if($hk1_total_factor == 0){
          $record['hk1_average'] = "noscore";
        }
        else{
          $record['hk1_average'] = number_format($hk1_average/$hk1_total_factor,2);
        }


        for($i=1;$i<=5;$i++){
          $month_score = [];
          $month_average = 0;
          $month_total_factor = 0;
          $scoretype_month = Scoretype::where('subject_id','=',$request['data'][0])
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',$student_id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $month_score[$score->type][0] = ($temp->score > 10) ? 0 : $temp->score;
                $month_score[$score->type][1] = $temp->note;
                $month_average += $month_score[$score->type][0] * $score->factor;
                $month_total_factor += $score->factor;
                $hk2_average += $month_score[$score->type][0] * $score->factor;
                $hk2_total_factor += $score->factor;
              }
              else{
                $month_score[$score->type][0] = "missing";
                $month_total_factor += $score->factor;
                $hk2_average += 0;
                $hk2_total_factor += $score->factor;
              }
            }

            $month_average = number_format(($month_average / $month_total_factor) , 2);
            $month_score['month_'.$i.'_average'] = $month_average;
          }
          else{
            $month_score['month_'.$i.'_average'] = 'noscore';
          }
          
          $record['month_'.$i] = $month_score;
        }
        if($hk2_total_factor == 0){
          $record['hk2_average'] = "noscore";
        }
        else{
          $record['hk2_average'] = number_format($hk2_average/$hk2_total_factor,2);
        }
        $record['scholastic_average'] = number_format((($record['hk1_average'] + 2*$record['hk2_average']) / 3),2);
        // if($hk1_total_factor == 0 && $hk2_total_factor == 0){
        //   $record['scholastic_average'] = (($record['hk1_average'] + 2*$record['hk2_average']) / 3);
          
        // }
        // elseif($hk1_total_factor == 0){
        //   $record['scholastic_average'] = $record['hk2_average'];
        // }
        // else{
        //   $record['scholastic_average'] = $record['hk1_average'];
        // }


      }
      return $record;
    }

    private function cal_summary_score($class_id, $student_id){
      $gpa_hk1 = 0;
      $gpa_hk2 = 0;
      $gpa = 0;
      $gpa_list = array();
      $year = substr($class_id, 0,2);
      $subject_id_list = Teacher::select('group')
                              ->whereIn('id',
                                          Schedule::select('teacher_id')
                                                  ->where('class_id','=',$class_id)
                                                  ->groupBy('teacher_id')
                                                  ->get()
                                       )
                              ->get();
      $total_subject = count($subject_id_list);
      if($total_subject == 0){
        $subject_id_list = Subject::select('id')->get();
        foreach ($subject_id_list as $key => $value) {
          $subject_id_list[$key]->group = $value->id;
        }
        $total_subject = count($subject_id_list);
      }
      
      foreach ($subject_id_list as $subject) {
          //tinh diem hk 1 cua tung mon
          $sub_key = Subject::find($subject->group)->subject_name;
          $scoretype_list = Scoretype::where('subject_id','=',$subject->group)
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
          $gpa_list[$sub_key] = $temp_gpa;
          $gpa_hk1 += $temp_gpa;

          // hk 2
          $scoretype_list = Scoretype::where('subject_id','=',$subject->group)
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
          $gpa_list[$sub_key] = number_format(($gpa_list[$sub_key] + 2*$temp_gpa)/3,2);
          $gpa_hk2 += $temp_gpa;
      }
      $gpa_hk1 = number_format(($gpa_hk1/$total_subject),2);
      $gpa_hk2 = number_format(($gpa_hk2/$total_subject),2);
      $gpa = number_format(($gpa_hk1 + 2*$gpa_hk2 )/ 3,2);
      $gpa = round( $gpa, 1, PHP_ROUND_HALF_UP);
      $gpa_list['tb_hk1'] = $gpa_hk1;
      $gpa_list['tb_hk2'] = $gpa_hk2;
      $gpa_list['tb_nam'] = $gpa;
      return $gpa_list;
    }
}
