<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Classes;
use App\Model\StudentClass;
use App\User;
use App\Model\Student;
use App\Model\Phancong;
use App\Model\Teacher;
use App\Model\Subject;
use App\Transcript;
use App\Model\Scoretype;
use DB;

class TranscriptController extends Controller
{
    public function get_view()
    {
        $student = Student::find(Auth::user()->id);
        $class_list = Classes::whereIn('id',StudentClass::select('class_id')->where('student_id','=',$student->id)->get())->get();
        foreach ($class_list as $key => $class) {
            $class['home_teacher'] = User::find($class->homeroom_teacher);
        }
        return view('studentpage.transcript', ['class_list' => $class_list]);
    }

    public function select_class(Request $request)
    {
        $class_id = $request['data'][0];
        $year = substr($class_id, 0, 2);
        $tb = [];
        $student = StudentClass::where('class_id','=',$class_id)->where('student_id','=',Auth::user()->id)->first();
        $phancong = Phancong::where('class_id','=',$class_id)->get();
        $temp = [];
        foreach ($phancong as $key => $row) {
       		$row['teacher_name'] = User::find($row->teacher_id)->fullname;
       		$row['subject'] = Subject::find(Teacher::find($row->teacher_id)->group);
          $row['class_id'] = $class_id;
       	}
        if(count($phancong) == 0){
          $phancong = Subject::all();
          foreach ($phancong as $key => $row) {
            $row['teacher_name'] = "_";
            $row['subject'] = Subject::find($row->id);
            $row['class_id'] = $class_id;
          }
        }
        $subject_list = Subject::select('id')->get();
        for($i=8;$i<=12;$i++){
          $scoretype_month = Scoretype::whereIn('subject_id',$subject_list)
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            $tb['tb_thang_'.$i] = 0;
            $month_factor = 0;
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',Auth::user()->id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $real_score = ($temp->score > 10) ? 0 : $temp->score;
                $tb['tb_thang_'.$i] += $real_score * $score->factor;
                $month_factor += $score->factor;
              }
              else{
                $tb['tb_thang_'.$i] += 0;
                $month_factor += $score->factor;
              }
            }
            $tb['tb_thang_'.$i] = number_format($tb['tb_thang_'.$i] / $month_factor ,2);
          }
          else{
            $tb['tb_thang_'.$i] = "noscore";
          }
        }
        for($i=1;$i<=5;$i++){
          $scoretype_month = Scoretype::whereIn('subject_id',$subject_list)
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            $tb['tb_thang_'.$i] = 0;
            $month_factor = 0;
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',Auth::user()->id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $real_score = ($temp->score > 10) ? 0 : $temp->score;
                $tb['tb_thang_'.$i] += $real_score * $score->factor;
                $month_factor += $score->factor;
              }
              else{
                $tb['tb_thang_'.$i] += 0;
                $month_factor += $score->factor;
              }
            }
            $tb['tb_thang_'.$i] = number_format($tb['tb_thang_'.$i] / $month_factor ,2);
          }
          else{
            $tb['tb_thang_'.$i] = "noscore";
          }
        }
        $thang = 0;
        $tb['tb_hk_1'] = 0;
        for($i=8;$i<=12;$i++){
          $tb['tb_hk_1'] += $tb['tb_thang_'.$i];
          if($tb['tb_thang_'.$i] != "noscore"){
            $thang = $thang + 1;
          }
        }
        if($thang == 0){
          $tb['tb_hk_1'] = "noscore";
        }else{
          $tb['tb_hk_1'] = number_format($tb['tb_hk_1'] / $thang , 2 );
        }

        $thang = 0;
        $tb['tb_hk_2'] = 0;
        for($i=1;$i<=5;$i++){
          $tb['tb_hk_2'] += $tb['tb_thang_'.$i];
          if($tb['tb_thang_'.$i] != "noscore"){
            $thang = $thang + 1;
          }
        }
        if($thang == 0){
          $tb['tb_hk_2'] = "noscore";
        }else{
          $tb['tb_hk_2'] = number_format($tb['tb_hk_2'] / $thang , 2 );
        }

        $tb['tb_nam'] = number_format(($tb['tb_hk_1'] + 2*$tb['tb_hk_2'])/3 ,2);

        $record['0'] = $phancong;
        $record['1'] = $tb;
        $record['2'] = $student;
        return $record;

    }

    public function select_subject(Request $request){
      $record = [];
      $class_id = $request['data'][1];
      $year = substr($class_id, 0,2);
      if($request['data'][0] == "all"){
        $tb = [];
        // $subject_list = Teacher::select('group')
        //                        ->whereIn(
        //                           'id',
        //                           Phancong::select('teacher_id')->where('class_id','=',$class_id)->get()
        //                         )->get();
        $subject_list = Subject::select('id')->get();
        for($i=8;$i<=12;$i++){
          $scoretype_month = Scoretype::whereIn('subject_id',$subject_list)
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            $tb['tb_thang_'.$i] = 0;
            $month_factor = 0;
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',Auth::user()->id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $real_score = ($temp->score > 10) ? 0 : $temp->score;
                $tb['tb_thang_'.$i] += $real_score * $score->factor;
                $month_factor += $score->factor;
              }
              else{
                $tb['tb_thang_'.$i] += 0;
                $month_factor += $score->factor;
              }
            }
            $tb['tb_thang_'.$i] = number_format($tb['tb_thang_'.$i] / $month_factor ,2);
          }
          else{
            $tb['tb_thang_'.$i] = "noscore";
          }
        }
        for($i=1;$i<=5;$i++){
          $scoretype_month = Scoretype::whereIn('subject_id',$subject_list)
                                      ->where('applyfrom','<=',$year)
                                      ->where('disablefrom','>=',$year)
                                      ->where('month','=',$i)
                                      ->get();
          if(count($scoretype_month) > 0){
            $tb['tb_thang_'.$i] = 0;
            $month_factor = 0;
            foreach ($scoretype_month as $key => $score) {
              $temp = Transcript::where('scholastic','=',$year)
                                ->where('student_id','=',Auth::user()->id)
                                ->where('scoretype_id','=',$score->id)
                                ->first();
              if($temp != null){
                $real_score = ($temp->score > 10) ? 0 : $temp->score;
                $tb['tb_thang_'.$i] += $real_score * $score->factor;
                $month_factor += $score->factor;
              }
              else{
                $tb['tb_thang_'.$i] += 0;
                $month_factor += $score->factor;
              }
            }
            $tb['tb_thang_'.$i] = number_format($tb['tb_thang_'.$i] / $month_factor ,2);
          }
          else{
            $tb['tb_thang_'.$i] = "noscore";
          }
        }
        $thang = 0;
        $tb['tb_hk_1'] = 0;
        for($i=8;$i<=12;$i++){
          $tb['tb_hk_1'] += $tb['tb_thang_'.$i];
          if($tb['tb_thang_'.$i] != "noscore"){
            $thang = $thang + 1;
          }
        }
        if($thang == 0){
          $tb['tb_hk_1'] = "noscore";
        }else{
          $tb['tb_hk_1'] = number_format($tb['tb_hk_1'] / $thang , 2 );
        }

        $thang = 0;
        $tb['tb_hk_2'] = 0;
        for($i=1;$i<=5;$i++){
          $tb['tb_hk_2'] += $tb['tb_thang_'.$i];
          if($tb['tb_thang_'.$i] != "noscore"){
            $thang = $thang + 1;
          }
        }
        if($thang == 0){
          $tb['tb_hk_2'] = "noscore";
        }else{
          $tb['tb_hk_2'] = number_format($tb['tb_hk_2'] / $thang , 2 );
        }

        $tb['tb_nam'] = number_format(($tb['tb_hk_1'] + 2*$tb['tb_hk_2'])/3 ,2);

        $record['type'] = 'all';
        $record['data'] = $tb;
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
                                ->where('student_id','=',Auth::user()->id)
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
                                ->where('student_id','=',Auth::user()->id)
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

        if($hk1_total_factor == 0 && $hk2_total_factor == 0){
          $record['scholastic_average'] = (($record['hk1_average'] + 2*$record['hk2_average']) / 3);
          
        }
        elseif($hk1_total_factor == 0){
          $record['scholastic_average'] = $record['hk2_average'];
        }
        else{
          $record['scholastic_average'] = $record['hk1_average'];
        }


      }
      return $record;
    }
}
