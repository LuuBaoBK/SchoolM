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
use DB;
use Auth;           

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

    // public function GPA_cal($class_id,$student_id){
    //     $gpa = 0;
    //     $total_factor = 0;
    //     $total_score = 0;
    //     $year = substr($class_id, 0,2);
    //     $subject_list = Teacher::select('group')
    //                             ->whereIn('id',
    //                                         Phancong::select('teacher_id')
    //                                                 ->where('class_id','=',$class_id)
    //                                                 ->get()
    //                                     )
    //                             ->get();

    //     $scoretype_list = Scoretype::whereIn('subject_id', $subject_list)
    //                            ->where('applyfrom','<=',$year)
    //                            ->where('disablefrom','>=',$year)
    //                            ->where('month','>=', 8)
    //                            ->get();
    //     if(count($scoretype_list) == 0 ){
    //         $hk1_gpa = 0;
    //     }
    //     else{
    //         foreach ($scoretype_list as $key => $scoretype) {
    //             $score = Transcript::where('scoretype_id','=',$scoretype->id)
    //                                 ->where('student_id','=',$student_id)
    //                                 ->where('scholastic','=',$year)
    //                                 ->first();
    //             if(count($score) == 0){
    //                 $total_score += 0;
    //             }
    //             else{
    //                 $total_score += $score->score;
    //             }
    //             $total_factor += $scoretype->factor;
    //         }
    //         $hk1_gpa = number_format($total_score/$total_factor,2);
    //     }

    //     $scoretype_list = Scoretype::whereIn('subject_id', $subject_list)
    //                            ->where('applyfrom','<=',$year)
    //                            ->where('disablefrom','>=',$year)
    //                            ->where('month','<', 8)
    //                            ->get();
    //     if(count($scoretype_list) == 0 ){
    //         $hk2_gpa = 0;
    //     }
    //     else{
    //         foreach ($scoretype_list as $key => $scoretype) {
    //             $score = Transcript::where('scoretype_id','=',$scoretype->id)
    //                                 ->where('student_id','=',$student_id)
    //                                 ->where('scholastic','=',$year)
    //                                 ->first();
    //             if(count($score) == 0){
    //                 $total_score += 0;
    //             }
    //             else{
    //                 $total_score += $score->score;
    //             }
    //             $total_factor += $scoretype->factor;
    //         }
    //         $hk2_gpa = number_format($total_score/$total_factor,2);
    //     }
    //     $gpa = number_format($hk1_gpa+2*$hk2_gpa / 3, 2);
        
    //     return $gpa;
    // }

    public function GPA_cal($class_id,$student_id){
        $gpa_hk1 = 0;
        $gpa_hk2 = 0;
        $gpa = 0;
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
        foreach ($subject_id_list as $subject) {
            //tinh diem hk 1 cua tung mon
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
}
