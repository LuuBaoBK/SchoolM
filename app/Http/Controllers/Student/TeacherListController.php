<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\Classes;
use Auth;
use App\User;
use App\Model\tkb;
use App\Model\phancong;
use App\Model\StudentClass;

class TeacherListController extends Controller
{
    public function get_view(){
        $year = substr(date("Y"), 2,2);
        $year = (date("m") < 8) ? ($year - 1) : $year;
        $class_id = StudentClass::where('student_id','=',Auth::user()->id)->where('class_id','like',$year."%")->first();
        if($class_id == null){
            return view('studentpage.teacherlist',['tkb' => null]);
        }
        else{
            $class = Classes::find($class_id->class_id);
            // $subject_list = Subject::orderBy('subject_name')->get();
            $tkb = tkb::where('T0', '=', $class->classname)
                    ->orWhere('T1', '=', $class->classname)
                    ->orWhere('T2', '=', $class->classname)
                    ->orWhere('T3', '=', $class->classname)
                    ->orWhere('T4', '=', $class->classname)
                    ->orWhere('T5', '=', $class->classname)
                    ->orWhere('T6', '=', $class->classname)
                    ->orWhere('T7', '=', $class->classname)
                    ->orWhere('T8', '=', $class->classname)
                    ->orWhere('T9', '=', $class->classname)
                    ->orWhere('T10', '=', $class->classname)
                    ->orWhere('T11', '=', $class->classname)
                    ->orWhere('T12', '=', $class->classname)
                    ->orWhere('T13', '=', $class->classname)
                    ->orWhere('T14', '=', $class->classname)
                    ->orWhere('T15', '=', $class->classname)
                    ->orWhere('T16', '=', $class->classname)
                    ->orWhere('T17', '=', $class->classname)
                    ->orWhere('T18', '=', $class->classname)
                    ->orWhere('T19', '=', $class->classname)
                    ->orWhere('T20', '=', $class->classname)
                    ->orWhere('T21', '=', $class->classname)
                    ->orWhere('T22', '=', $class->classname)
                    ->orWhere('T23', '=', $class->classname)
                    ->orWhere('T24', '=', $class->classname)
                    ->orWhere('T25', '=', $class->classname)
                    ->orWhere('T26', '=', $class->classname)
                    ->orWhere('T27', '=', $class->classname)
                    ->orWhere('T28', '=', $class->classname)
                    ->orWhere('T29', '=', $class->classname)
                    ->orWhere('T30', '=', $class->classname)
                    ->orWhere('T31', '=', $class->classname)
                    ->orWhere('T32', '=', $class->classname)
                    ->orWhere('T33', '=', $class->classname)
                    ->orWhere('T34', '=', $class->classname)
                    ->orWhere('T35', '=', $class->classname)
                    ->orWhere('T36', '=', $class->classname)
                    ->orWhere('T37', '=', $class->classname)
                    ->orWhere('T38', '=', $class->classname)
                    ->orWhere('T39', '=', $class->classname)
                    ->orWhere('T40', '=', $class->classname)
                    ->orWhere('T41', '=', $class->classname)
                    ->orWhere('T42', '=', $class->classname)
                    ->orWhere('T43', '=', $class->classname)
                    ->orWhere('T44', '=', $class->classname)
                    ->orWhere('T45', '=', $class->classname)
                    ->orWhere('T46', '=', $class->classname)
                    ->orWhere('T47', '=', $class->classname)
                    ->orWhere('T48', '=', $class->classname)
                    ->orWhere('T49', '=', $class->classname)
                    ->orderBy('subject_name')
                    ->get();
            $teacher = Teacher::where('id','=',$tkb[0]->teacher_id)->first();
            $teacher->user;
            $teacher->teach;
            $teacher->my_position;
            $src = "/uploads/teachers/".$teacher->id;
            if(file_exists(".".$src."jpg")){
                $src = $src."jpg";
            }
            else if(file_exists(".".$src."png")){
                $src = $src."png";
            }
            else{
                $src = "/uploads/userAvatar.png";
            }
            return view('studentpage.teacherlist',['tkb' => $tkb, 'teacher' => $teacher, 'src' => $src]);
        }
    }

    public function select_teacher(Request $request){
        $teacher_id = $request['teacher_id'];
        $teacher = Teacher::where('id','=',$teacher_id)->first();
        $teacher->user;
        $teacher->teach;
        $teacher->my_position;
        $src = "/uploads/teachers/".$teacher->id;
        if(file_exists(".".$src.".jpg")){
            $src = $src.".jpg";
        }
        else if(file_exists(".".$src.".png")){
            $src = $src.".png";
        }
        else{
            $src = "/uploads/userAvatar.png";
        }
        $teacher->src = $src;
        return $teacher;
    }
}
