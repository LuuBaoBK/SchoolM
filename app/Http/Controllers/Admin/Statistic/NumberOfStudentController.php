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
class NumberOfStudentController extends Controller
{
    public function get_view(){
        return view('adminpage.statistic.numberofstudent');
    }

    public function get_data(Request $request){
        $data = [];
        $labels = [];
        $year = date("Y");
        $month = date("m");
        $year = ($month < 8) ? $year-1 : $year;
        // $year = 2013;
        $start = $year - 7;
        if($start <= 2010){
            $start = 2010;
        }

        // Student per Year
        for($i = $start; $i <= $year ; $i++){
            $student_count = Student::where('enrolled_year','=',$i)->count();
            array_push($data, $student_count);
            array_push($labels, $i);
        }
        $record['chart1']['data'] = $data;
        $record['chart1']['labels'] = $labels;

        // Male & Female
        $student_male_count = Student::whereIn('id', 
                                                User::select('id')
                                                    ->where('gender','=','M')->get()
                                        )
                                        ->where('enrolled_year','=',$year)
                                        ->count();
        $student_female_count = Student::whereIn('id', 
                                                User::select('id')
                                                    ->where('gender','=','F')->get()
                                        )
                                        ->where('enrolled_year','=',$year)
                                        ->count();
        $record['student_male_count'] = $student_male_count;
        $record['student_female_count'] = $student_female_count;

        // Number of Student per Grade
        $student_grade_6_1 = StudentClass::where('class_id','like',substr($year, 2,2)."_6_%")->count();
        $student_grade_7_1 = StudentClass::where('class_id','like',substr($year, 2,2)."_7_%")->count();
        $student_grade_8_1 = StudentClass::where('class_id','like',substr($year, 2,2)."_8_%")->count();
        $student_grade_9_1 = StudentClass::where('class_id','like',substr($year, 2,2)."_9_%")->count();
        $record['chart2']['grade_6_1'] = $student_grade_6_1;
        $record['chart2']['grade_7_1'] = $student_grade_7_1;
        $record['chart2']['grade_8_1'] = $student_grade_8_1;
        $record['chart2']['grade_9_1'] = $student_grade_9_1;

        $student_grade_6_2 = StudentClass::where('class_id','like',substr($year-1, 2,2)."_6_%")->count();
        $student_grade_7_2 = StudentClass::where('class_id','like',substr($year-1, 2,2)."_7_%")->count();
        $student_grade_8_2 = StudentClass::where('class_id','like',substr($year-1, 2,2)."_8_%")->count();
        $student_grade_9_2 = StudentClass::where('class_id','like',substr($year-1, 2,2)."_9_%")->count();
        $record['chart2']['grade_6_2'] = $student_grade_6_2;
        $record['chart2']['grade_7_2'] = $student_grade_7_2;
        $record['chart2']['grade_8_2'] = $student_grade_8_2;
        $record['chart2']['grade_9_2'] = $student_grade_9_2;

        $record['chart2']['label1'] = $year;
        $record['chart2']['label2'] = $year-1;

        // Propotion of student / grade
        $total = $student_grade_6_1 + $student_grade_7_1 + $student_grade_8_1 + $student_grade_9_1;
        $record['chart3']['grade_6'] = $student_grade_6_1;
        $record['chart3']['grade_7'] = $student_grade_7_1;
        $record['chart3']['grade_8'] = $student_grade_8_1;
        $record['chart3']['grade_9'] = $student_grade_9_1;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_6_%")
                                                ->get()
                                )
                      ->where('gender','=','M')->count();
        $record['chart3']['male_6'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_6_%")
                                                ->get()
                                )
                      ->where('gender','=','F')->count();
        $record['chart3']['female_6'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_7_%")
                                                ->get()
                                )
                      ->where('gender','=','M')->count();
        $record['chart3']['male_7'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_7_%")
                                                ->get()
                                )
                      ->where('gender','=','F')->count();
        $record['chart3']['female_7'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_8_%")
                                                ->get()
                                )
                      ->where('gender','=','M')->count();
        $record['chart3']['male_8'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_8_%")
                                                ->get()
                                )
                      ->where('gender','=','F')->count();
        $record['chart3']['female_8'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_9_%")
                                                ->get()
                                )
                      ->where('gender','=','M')->count();
        $record['chart3']['male_9'] = $temp;

        $temp =     User::whereIn('id',
                                    StudentClass::select('student_id')
                                                ->where('class_id','like',substr($year, 2,2)."_9_%")
                                                ->get()
                                )
                      ->where('gender','=','F')->count();
        $record['chart3']['female_9'] = $temp;


        return $record;
    }
}
