<?php

namespace App\Http\Controllers\Admin\Statistic;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Sysvar;
use App\Model\Student;
use App\Model\Teacher;
use App\User;
use App\Model\StudentClass;
use App\Transcript;
use App\Subject;

class TranscriptController extends Controller
{
    public function get_view(){
        return view('adminpage.statistic.transcript');
    }

    public function get_data(Request $request){
        // Chart 1
        $year = substr(date("Y"),2,2);
        $year = (date("m") < 8)? $year-1 : $year;
        $data['chart1'] = $this->get_data_chart1($year);
        $data['chart2'] = $this->get_data_chart2($year);
        return $data;
    }

    private function get_data_chart1($year){
        $data = array(0,0,0,0,0,0,0,0,0,0,0);
        $student_list = StudentClass::where('class_id','like',$year."%")->get();
        if(count($student_list) == 0){
            $data = array(0,0,0,0,0,0,0,0,0,0,0);
        }
        else{
            foreach ($student_list as $key => $student) {
                if($student->GPA < 0.5){
                    $data[0] += 1;
                }
                else if($student->GPA < 1.5){
                    $data[1] += 1;
                }
                else if($student->GPA < 2.5){
                    $data[2] += 1;
                }
                else if($student->GPA < 3.5){
                    $data[3] += 1;
                }
                else if($student->GPA < 4.5){
                    $data[4] += 1;
                }
                else if($student->GPA < 5.5){
                    $data[5] += 1;
                }
                else if($student->GPA < 6.5){
                    $data[6] += 1;
                }
                else if($student->GPA < 7.5){
                    $data[7] += 1;
                }
                else if($student->GPA < 8.5){
                    $data[8] += 1;
                }
                else if($student->GPA < 9.5){
                    $data[9] += 1;
                }
                else{
                    $data[10] += 1;
                }
            }      
        }
        $datachart1['data1'] = $data;
        $datachart1['label1'] = "20".($year)."-"."20".($year+1);
        // *****************************************
        $data = array(0,0,0,0,0,0,0,0,0,0,0);
        $student_list = StudentClass::where('class_id','like',($year-1)."%")->get();
        if(count($student_list) == 0){
            $data = array(0,0,0,0,0,0,0,0,0,0,0);
        }
        else{
            foreach ($student_list as $key => $student) {
                if($student->GPA < 0.5){
                    $data[0] += 1;
                }
                else if($student->GPA < 1.5){
                    $data[1] += 1;
                }
                else if($student->GPA < 2.5){
                    $data[2] += 1;
                }
                else if($student->GPA < 3.5){
                    $data[3] += 1;
                }
                else if($student->GPA < 4.5){
                    $data[4] += 1;
                }
                else if($student->GPA < 5.5){
                    $data[5] += 1;
                }
                else if($student->GPA < 6.5){
                    $data[6] += 1;
                }
                else if($student->GPA < 7.5){
                    $data[7] += 1;
                }
                else if($student->GPA < 8.5){
                    $data[8] += 1;
                }
                else if($student->GPA < 9.5){
                    $data[9] += 1;
                }
                else{
                    $data[10] += 1;
                }
            }
        }
        $datachart1['data2'] = $data;
        $datachart1['label2'] = "20".($year-1)."-"."20".$year;
        return $datachart1;
    }

    private function get_data_chart2($year){
        $total_grade_6_1 = StudentClass::where('class_id','like',($year-1)."_6_%")->count();
        $total_grade_6_2 = StudentClass::where('class_id','like',$year."_6_%")->count();
        $total_grade_7_1 = StudentClass::where('class_id','like',($year-1)."_7_%")->count();
        $total_grade_7_2 = StudentClass::where('class_id','like',$year."_7_%")->count();
        $total_grade_8_1 = StudentClass::where('class_id','like',($year-1)."_8_%")->count();
        $total_grade_8_2 = StudentClass::where('class_id','like',$year."_8_%")->count();
        $total_grade_9_1 = StudentClass::where('class_id','like',($year-1)."_9_%")->count();
        $total_grade_9_2 = StudentClass::where('class_id','like',$year."_9_%")->count();
        $data = array(0,0,0,0,0,0,0,0);
        $data[0] = round(StudentClass::where('class_id','like',($year-1)."_6%")->where('GPA','<',5)->count() / $total_grade_6_1,2) * 100;
        $data[1] = round(StudentClass::where('class_id','like',$year."_6%")->where('GPA','<',5)->count() / $total_grade_6_2,2) * 100;
        $data[2] = round(StudentClass::where('class_id','like',($year-1)."_7%")->where('GPA','<',5)->count() / $total_grade_7_1,2) * 100;
        $data[3] = round(StudentClass::where('class_id','like',$year."_7%")->where('GPA','<',5)->count() / $total_grade_7_2,2) * 100;
        $data[4] = round(StudentClass::where('class_id','like',($year-1)."_8%")->where('GPA','<',5)->count() / $total_grade_8_1,2) * 100;
        $data[5] = round(StudentClass::where('class_id','like',$year."_8%")->where('GPA','<',5)->count() / $total_grade_8_2,2) * 100;
        $data[6] = round(StudentClass::where('class_id','like',($year-1)."_9%")->where('GPA','<',5)->count() / $total_grade_9_1,2) * 100;
        $data[7] = round(StudentClass::where('class_id','like',$year."_9%")->where('GPA','<',5)->count() / $total_grade_9_2,2) * 100;
        $datachart2['data1'] = $data;

        $data = array(0,0,0,0,0,0,0,0);
        $data[0] = round(StudentClass::where('class_id','like',($year-1)."_6%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_6_1,2) * 100;
        $data[1] = round(StudentClass::where('class_id','like',$year."_6%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_6_2,2) * 100;
        $data[2] = round(StudentClass::where('class_id','like',($year-1)."_7%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_7_1,2) * 100;
        $data[3] = round(StudentClass::where('class_id','like',$year."_7%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_7_2,2) * 100;
        $data[4] = round(StudentClass::where('class_id','like',($year-1)."_8%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_8_1,2) * 100;
        $data[5] = round(StudentClass::where('class_id','like',$year."_8%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_8_2,2) * 100;
        $data[6] = round(StudentClass::where('class_id','like',($year-1)."_9%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_9_1,2) * 100;
        $data[7] = round(StudentClass::where('class_id','like',$year."_9%")->where('GPA','>=',5)->where('GPA','<=',7.5)->count() / $total_grade_9_2,2) * 100;
        $datachart2['data2'] = $data;

        $data = array(0,0,0,0,0,0,0,0);
        $data[0] = round(StudentClass::where('class_id','like',($year-1)."_6%")->where('GPA','>',7.5)->count() / $total_grade_6_1,2) * 100;
        $data[1] = round(StudentClass::where('class_id','like',$year."_6%")->where('GPA','>',7.5)->count() / $total_grade_6_2,2) * 100;
        $data[2] = round(StudentClass::where('class_id','like',($year-1)."_7%")->where('GPA','>',7.5)->count() / $total_grade_7_1,2) * 100;
        $data[3] = round(StudentClass::where('class_id','like',$year."_7%")->where('GPA','>',7.5)->count() / $total_grade_7_2,2) * 100;
        $data[4] = round(StudentClass::where('class_id','like',($year-1)."_8%")->where('GPA','>',7.5)->count() / $total_grade_8_1,2) * 100;
        $data[5] = round(StudentClass::where('class_id','like',$year."_8%")->where('GPA','>',7.5)->count() / $total_grade_8_2,2) * 100;
        $data[6] = round(StudentClass::where('class_id','like',($year-1)."_9%")->where('GPA','>',7.5)->count() / $total_grade_9_1,2) * 100;
        $data[7] = round(StudentClass::where('class_id','like',$year."_9%")->where('GPA','>',7.5)->count() / $total_grade_9_2,2) * 100;
        $datachart2['data3'] = $data;

        $datachart2['year1'] = "20".($year-1);
        $datachart2['year2'] = "20".$year;
        return $datachart2;
    }
    
}
