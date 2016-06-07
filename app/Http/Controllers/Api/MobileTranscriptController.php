<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Transcript;
use App\Model\Scoretype;
use App\Model\Teacher;
use App\Model\Classes;
use App\User;
use App\Model\StudentClass;
use Auth;
use App\Model\Schedule;

class MobileTranscriptController extends Controller
{
    public function get_transcript(Request $request){
        $month = $this->format_month_code($request['data']);
        $id = $request['id'];
        $year = substr(date("Y"), 2,2);
        $year = (date("m") < 8 ) ? ($year-1) : $year;
        $tb = array();
        if($month == "summary"){
            $tb = $this->cal_summary_score($year);
        }
        // end summary
        else{
            $subject_list = Subject::select('id')->get();
            foreach ($subject_list as $key => $subject) {
                $scoretype_month = Scoretype::where('subject_id','=',$subject->id)
                                            ->where('applyfrom','<=',$year)
                                            ->where('disablefrom','>=',$year)
                                            ->where('month','=',$month)
                                            ->get();
                $tb[$subject->id] = 0;
                $month_factor = 0;
                if(count($scoretype_month) > 0){
                    foreach ($scoretype_month as $key => $score_type) {
                        $temp = Transcript::where('scholastic','=',$year)
                                          ->where('student_id','=',$id)
                                          ->where('scoretype_id','=',$score_type->id)
                                          ->first();
                        if($temp != null){
                            $real_score = ($temp->score > 10) ? 0 : $temp->score;
                            $tb[$subject->id] += $real_score * $score_type->factor;
                            $month_factor += $score_type->factor;
                        }
                          else{
                            $tb[$subject->id] += 0;
                            $month_factor += $score_type->factor;
                        }
                    }
                    $tb[$subject->id] = number_format($tb[$subject->id] / $month_factor ,2);
                }
                else{
                    $tb[$subject->id] = "no_score";
                }
            }
        }
        $subject_list = Subject::all();
        $temp_list = array();
        foreach ($subject_list as $key => $value) {
          $temp_list[$value->id] = $value->subject_name;
        }
        $data = array();
        $data['tb'] = array();
        $data['subject_list'] = array();

        foreach ($tb as $key => $value) {
          array_push($data['tb'], $value);
        }
        if($month == "summary"){
          foreach ($tb as $key => $value) {
            array_push($data['subject_list'],$key);
          }
        }
        else{
          foreach ($subject_list as $key => $value) {
            array_push($data['subject_list'],$value->subject_name);
          }
        }
        return $data;
    }

    private function format_month_code($month){
      switch ($month) {
        case '1':
          return "8";
          break;
        case '2':
          return "9";
          break;
        case '3':
          return "10";
          break;
        case '4':
          return "11";
          break;
        case '5':
          return "12";
          break;
        case '6':
          return "1";
          break;
        case '7':
          return "2";
          break;
        case '8': 
          return "3";
          break;
        case '9':
          return "4";
          break;
        case '10':
          return "5";
          break; 
        default:
          return "summary";
          break;
      }
    }

    public function te_get_stu_detail(Request $request){
      $id = $request['id'];
      $student = User::find($id);
      $src =  '\uploads\\'.$student->student->enrolled_year.'\\'.$student->student_id;
        if(file_exists(".".$src.".jpg")){
          $src = $src.".jpg";
        }
        else if(file_exists(".".$src.".png")){
          $src = $src.".png";
        }
        else{
          $src = "\uploads\userAvatar.png";
        }
        $temp['avatar'] = $src;
        $temp['email'] = $student->id."@schoolm.com";
        $temp['name'] = $student->fullname;
        $temp['gender'] = ($student->gender == "M")? "Nam" : "Nữ";
        if($student->dateofbirth != "0000-00-00")
        {
            $mydateofbirth = date_create_from_format("Y-m-d", $student->dateofbirth);
            $mydateofbirth = date_format($mydateofbirth,"d/m/Y");
        }
        else{
            $mydateofbirth = "";
        }

        $temp['birthday'] = $mydateofbirth;
        $parent = User::find($student->student->parent_id);
        $temp['parent'] = $parent->fullname;
        $temp['address'] = $parent->address;
        $temp['phone'] = $parent->parent->mobilephone;

      return $temp;
    }

    public function get_list_classes(){
      $year = substr(date("Y"),2);
      $year = (date("m") < 8) ? ($year -1 ) : $year;
      $user= Auth::user();
      $return_data = array();
      $listClass = Schedule::where("teacher_id" , "=", $user->id)
                            ->where('class_id','like',$year."%")
                            ->groupBy('class_id')->get();
      foreach ($listClass as $key => $value) {
        $class_name = Classes::where('id','=',$value->class_id)->first();
        $temp['class_id'] = $value->class_id;
        $temp['class_name'] = $class_name->classname;
        array_push($return_data, $temp);
      }
      return $return_data;
    }


    public function te_get_stulist(Request $request){
      $return_data['liststudents'] = array();
      $class_id = $request['data'];
      $class = Classes::where('id','=',$class_id)->first();
      $student_list = $class->students;
      foreach ($student_list as $key => $student) {
        $src =  '\uploads\\'.$student->enrolled_year.'\\'.$student->student_id;
        if(file_exists(".".$src.".jpg")){
          $src = $src.".jpg";
        }
        else if(file_exists(".".$src.".png")){
          $src = $src.".png";
        }
        else{
          $src = "\uploads\userAvatar.png";
        }
        $temp['avatar'] = $src;
        $temp['name'] = User::find($student->student_id)->fullname;
        $temp['ma'] = $student->student_id;
        array_push($return_data['liststudents'], $temp);
      }
      return $return_data;
    }

    public function get_te_list(Request $request){
      $id = $request['data'];
      $year = substr(date("Y"), 2);
      $year = (date("m") < 8) ? ($year-1) : $year;
      $class = StudentClass::where('class_id','like',$year."%")->where('student_id','=',$id)->first();
      $return_data['listteachers'] = array();
      if($class == null){
        $return_data['listteachers'] = [];
      }
      else{
        $teacher_id_list = Schedule::where('class_id','=',$class->class_id)->groupBy('teacher_id')->get();
        if(count($teacher_id_list) == 0){
          $return_data['listteachers'] = [];
        }
        else{
          foreach ($teacher_id_list as $key => $teacher) {
            $src =  '\uploads\teacher\\'.$teacher->teacher_id;
            if(file_exists(".".$src.".jpg")){
              $src = $src.".jpg";
            }
            else if(file_exists(".".$src.".png")){
              $src = $src.".png";
            }
            else{
              $src = "\uploads\userAvatar.png";
            }
            $temp['avatar'] = $src;
            $temp['name'] = User::find($teacher->teacher_id)->fullname;
            $temp['email'] = $teacher->teacher_id."@schoolm.com";
            $temp['subject'] = Subject::find(Teacher::find($teacher->teacher_id)->group)->subject_name;
            array_push($return_data['listteachers'], $temp);
          }
          if(count($return_data['listteachers']) == 0){
            $return_data['listteachers'] = "empty";
          };
        }
      }
      return $return_data;
    }

    private function cal_summary_score($year){
      $student_id = Auth::user()->id;
      $gpa_hk1 = 0;
      $gpa_hk2 = 0;
      $gpa = 0;
      $gpa_list = array();
      $subject_id_list = Subject::select('id')->get();
      foreach ($subject_id_list as $key => $value) {
        $subject_id_list[$key]->group = $value->id;
      }
      $total_subject = count($subject_id_list);
      
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


