<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Subject;
use App\Model\StudentClass;
use App\Model\Scoretype;
use App\Transcript;
use App\User;

class ReportController extends Controller
{
    public function get_view_scholastic(){
        return view('adminpage.report.general');
    }

    public function report_semester_1(){
        $year = substr(date("Y"), 2);
        $year = (date("m") < 8) ? ($year-1) : ($year);
        $class_list = Classes::where('id','like',$year."_6_B_%")->get();
        $total_class = count($class_list);
        $subject_list = Subject::all();
        $tb = array();
        foreach ($class_list as $class_key => $class) {
            $student_list = StudentClass::where('class_id','=',$class->id)->get();
            if(count($student_list) > 0){
                foreach ($student_list as $stu_key => $stu) {
                    // tinh diem 1 hoc sinh
                    foreach ($subject_list as $sub_key => $subject) {
                        $scoretype_month = Scoretype::where('subject_id','=',$subject->id)
                                                    ->where('applyfrom','<=',$year)
                                                    ->where('disablefrom','>=',$year)
                                                    ->where('month','>=',8)
                                                    ->get();
                        $tb[$subject->id] = 0;
                        $month_factor = 0;
                        if(count($scoretype_month) > 0){
                            foreach ($scoretype_month as $scoretyep_key => $score_type) {
                                $temp = Transcript::where('scholastic','=',$year)
                                                  ->where('student_id','=',$stu->student_id)
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
                    $tb['gpa'] = 0;
                    foreach ($tb as $key => $value) {
                        if($value != "no_score")
                        $tb['gpa'] += $value;
                    }
                        $tb['gpa'] = number_format($tb['gpa'] / count($subject_list),2);
                    $student_list[$stu_key]['score_list'] = $tb;
                    $student_list[$stu_key]['fullname'] = User::find($stu->student_id)->fullname;
                }
            }
            $class_list[$class_key]['student_list'] = $student_list;
            $class_list[$class_key]['total_student'] = count($student_list);
        }
        return view('adminpage.report.report_semester_1',['class_list' => $class_list,
                                                          'total_class' => $total_class,
                                                          'subject_list' => $subject_list,
                                                        ]);
    }

    public function report_semester_2(){
        $year = substr(date("Y"), 2);
        $year = (date("m") < 8) ? ($year-1) : ($year);
        $class_list = Classes::where('id','like',$year."_6_B%")->get();
        $total_class = count($class_list);
        $subject_list = Subject::all();
        $tb = array();
        foreach ($class_list as $class_key => $class) {
            $student_list = StudentClass::where('class_id','=',$class->id)->get();
            if(count($student_list) > 0){
                foreach ($student_list as $stu_key => $stu) {
                    // tinh diem 1 hoc sinh
                    foreach ($subject_list as $sub_key => $subject) {
                        $scoretype_month = Scoretype::where('subject_id','=',$subject->id)
                                                    ->where('applyfrom','<=',$year)
                                                    ->where('disablefrom','>=',$year)
                                                    ->where('month','<',8)
                                                    ->get();
                        $tb[$subject->id] = 0;
                        $month_factor = 0;
                        if(count($scoretype_month) > 0){
                            foreach ($scoretype_month as $scoretyep_key => $score_type) {
                                $temp = Transcript::where('scholastic','=',$year)
                                                  ->where('student_id','=',$stu->student_id)
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
                    $tb['gpa'] = 0;
                    foreach ($tb as $key => $value) {
                        if($value != "no_score")
                        $tb['gpa'] += $value;
                    }
                        $tb['gpa'] = number_format($tb['gpa'] / count($subject_list));
                    $student_list[$stu_key]['score_list'] = $tb;
                    $student_list[$stu_key]['fullname'] = User::find($stu->student_id)->fullname;
                }
            }
            $class_list[$class_key]['student_list'] = $student_list;
            $class_list[$class_key]['total_student'] = count($student_list);
        }
        return view('adminpage.report.report_semester_1',['class_list' => $class_list,
                                                          'total_class' => $total_class,
                                                          'subject_list' => $subject_list,
                                                        ]);
    }

    public function report_semester_3(){
        $year = substr(date("Y"), 2);
        $year = (date("m") < 8) ? ($year-1) : ($year);
        $class_list = Classes::where('id','like',$year."%")->get();
        $total_class = count($class_list);
        $subject_list = Subject::all();
        $tb = array();
        foreach ($class_list as $class_key => $class) {
            $student_list = StudentClass::where('class_id','=',$class->id)->get();
            if(count($student_list) > 0){
                foreach ($student_list as $stu_key => $stu) {
                    // tinh diem 1 hoc sinh
                    foreach ($subject_list as $sub_key => $subject) {
                        $scoretype_month = Scoretype::where('subject_id','=',$subject->id)
                                                    ->where('applyfrom','<=',$year)
                                                    ->where('disablefrom','>=',$year)
                                                    ->where('month','>=',8)
                                                    ->get();
                        $tb[$subject->id] = 0;
                        $month_factor = 0;
                        if(count($scoretype_month) > 0){
                            foreach ($scoretype_month as $scoretyep_key => $score_type) {
                                $temp = Transcript::where('scholastic','=',$year)
                                                  ->where('student_id','=',$stu->student_id)
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


                    $tb['gpa'] = 0;
                    foreach ($tb as $key => $value) {
                        if($value != "no_score")
                        $tb['gpa'] += $value;
                    }
                        $tb['gpa'] = number_format($tb['gpa'] / count($subject_list));
                    $student_list[$stu_key]['score_list'] = $tb;
                    $student_list[$stu_key]['fullname'] = User::find($stu->student_id)->fullname;
                }
            }
            $class_list[$class_key]['student_list'] = $student_list;
            $class_list[$class_key]['total_student'] = count($student_list);
        }
        return view('adminpage.report.report_semester_1',['class_list' => $class_list,
                                                          'total_class' => $total_class,
                                                          'subject_list' => $subject_list,
                                                        ]);
    }
}
