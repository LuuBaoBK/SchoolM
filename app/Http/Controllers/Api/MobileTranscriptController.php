<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Transcript;
use App\Model\Scoretype;

class MobileTranscriptController extends Controller
{
    public function get_transcript(Request $request){
        $month = $this->format_month_code($request['data']);
        $id = $request['id'];
        $year = substr(date("Y"), 2,2);
        $year = (date("m") < 8 ) ? ($year-1) : $year;
        $tb = array();
        if($month == "summary"){
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
                                    ->where('student_id','=',$id)
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
                                    ->where('student_id','=',$id)
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
        }
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
          for($i=8;$i<=12;$i++){
            array_push($data['subject_list'],"Trung Bình Tháng ".$i);
          }
          for($i=1;$i<=5;$i++){
            array_push($data['subject_list'],"Trung Bình Tháng ".$i);
          }
          array_push($data['subject_list'],"Trung Bình HK1");
          array_push($data['subject_list'],"Trung Bình HK2");
          array_push($data['subject_list'],"Trung Bình Cả Năm");
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
}
