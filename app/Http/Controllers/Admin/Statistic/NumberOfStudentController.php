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
        $year = 2013;
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
        $record['data1'] = $data;
        $record['labels1'] = $labels;

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

        // Student per Grade
        $student_grade_6 = StudentClass::where('class_id','like',substr($year, 2,2)."_6_%")->count();
        $student_grade_7 = StudentClass::where('class_id','like',substr($year, 2,2)."_7_%")->count();
        $student_grade_8 = StudentClass::where('class_id','like',substr($year, 2,2)."_8_%")->count();
        $student_grade_9 = StudentClass::where('class_id','like',substr($year, 2,2)."_9_%")->count();
        $student_grade_6 = 25;
        $student_grade_7 = 35;
        $student_grade_8 = 15;
        $student_grade_9 = 28;
        $record['student_grade_6'] = $student_grade_6;
        $record['student_grade_7'] = $student_grade_7;
        $record['student_grade_8'] = $student_grade_8;
        $record['student_grade_9'] = $student_grade_9;

        return $record;
    }
}
