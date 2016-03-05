<?php

namespace App\Http\Controllers\Admin\Classes;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\StudentClass;
use App\Model\Classes;
use App\User;

class StudentInClassController extends Controller
{
    //
    
    public function view(){
        return view("adminpage.class.studentclassinfo");
    }

    public function updateclassname(Request $request){
        $scholastic = $request['scholastic'];
        $grade      = $request['grade'];
        $group      = $request['group'];

        if($scholastic == '0' || $scholastic == '-1'){
            $id = "%";
        }
        else{
            $id = $scholastic."_%";
        }

        $name = "";
        if($grade != '0' && $grade != '-1'){
            $name .= $grade;
        }
        else{
            $name .= "%";
        }

        if($group != '0' && $group != '-1'){
            $name .= $group;
        }
        else{
            // do nothing
        }

        $name .= "%";
        

        $classname = Classes::where('id','like',$id)->where('classname','like',$name)->get();
        $count = Classes::where('id','like', $id)->where('classname','like',$name)->count();
        $record['count'] = $count;
        $record['data'] = $classname;
        return $record;
    }

    public function showclass(Request $request){
        $scholastic = $request['scholastic'];
        $grade      = $request['grade'];
        $group      = $request['group'];
        $classname  = $request['classname'];
        $isPassed   = $request['isPassed'];

        if($scholastic == '0' || $scholastic == '-1'){
            $id     = "%";
        }
        else{
            $id     = $scholastic."_%";
        }

        if($isPassed == '2' || $isPassed == '-1'){
            $isPassed = "%";
        }
        else{
            $isPassed .= "%";
        }

        if($classname == '0'){
            $name = "";
            if($grade != '0' && $grade != '-1'){
                $name .= $grade;
            }
            else{
                $name .= "%";
            }

            if($group != '0' && $group != '-1'){
                $name .= $group;
            }
            else{
                // do nothing
            }

            $name .= "%";

            $record = StudentClass::whereIn('class_id',
                                            Classes::select('id')
                                                   ->where('id','like',$id)
                                                   ->where('classname','like',$name)
                                                   ->get())
                                  ->where('ispassed','like',$isPassed)
                                  ->get();
        }
        else{
            $record = StudentClass::whereIn('class_id',
                                            Classes::select('id')
                                                   ->where('id','=',$classname)
                                                   ->get())
                                    ->where('ispassed','like', $isPassed)
                                    ->get();
        }
        
        foreach ($record as $key => $value) {
            $value->student->user;
        }
        return $record;
    }

    public function showstudent(Request $request){
        $enrolled_year      = $request['enrolled_year'];
        $studentid          = $request['studentid'];
        $search_fullname   = $request['search_fullname'];

        if($enrolled_year == "-1"){
            $record['error'] = '0';
            return $record;
        }

        $student_id_list = User::select('id')
                               ->where('id','like','s_%')
                               ->where('fullname','like',$search_fullname.'%')
                               ->get();

        $studentlist = Student::whereIn('id',$student_id_list)
                                  ->where('enrolled_year','like',"%".$enrolled_year."%")
                                  ->get();

        $count = count($studentlist);
        if($count > 0){
            foreach ($studentlist as $key => $value) {
                $value->user;
            }
            $record = $studentlist;
            return $record;
        }
        else{
            $record['error'] = '0';
            return $record;
        }
        
    }

    public function addstudent(Request $request){
        $studentlist = $request['studentlist'];
        $classid_new = $request['classid_new'];
        $classid_old = $request['classid_old'];
        $type        = $request['type'];

        if($classid_new == "-1"){
            $record['error'] = "Please Select New Class First";
            return $record;
        }

        if($type == "1"){
            $successlist    = Student::whereIn('id',$studentlist[0])
                                     ->whereNotin(
                                                    'id', 
                                                    StudentClass::select('student_id')
                                                                ->where('class_id','=',$classid_new)
                                                                ->get()
                                                )
                                     ->get();
            $errorlist      = Student::select('id')
                                     ->whereIn('id',$studentlist[0])
                                     ->whereIn(
                                                    'id', 
                                                    StudentClass::select('student_id')
                                                                ->where('class_id','=',$classid_new)
                                                                ->get()
                                                )
                                     ->get();
            if($classid_old != "0"){
                $warninglist    = Student::select('id')
                                     ->whereIn('id',$studentlist[0])
                                     ->whereNotin(
                                                    'id', 
                                                    StudentClass::select('student_id')
                                                                ->where('class_id','=',$classid_new)
                                                                ->get()
                                                )
                                     ->whereIn(
                                                'id',
                                                StudentClass::select('student_id')
                                                            ->where('class_id','=',$classid_old)
                                                            ->where('ispassed','=','0')
                                                            ->get()
                                                )
                                     ->get();
            }
            else{
                $warninglist    = [];
            }

        }
        else{
            $successlist    = Student::whereIn('id',$studentlist[0])
                                     ->whereNotin(
                                                    'id', 
                                                    StudentClass::select('student_id')
                                                                ->where('class_id','=',$classid_new)
                                                                ->get()
                                                )
                                     ->get();

            $errorlist      = Student::select('id')
                                     ->whereIn('id',$studentlist[0])
                                     ->whereIn(
                                                    'id', 
                                                    StudentClass::select('student_id')
                                                                ->where('class_id','=',$classid_new)
                                                                ->get()
                                                )
                                     ->get();
            $warninglist    = [];
        }
        foreach ($successlist as $key => $value) {
            $studentclass = new StudentClass;
            $studentclass->class_id = $classid_new;
            $studentclass->student_id = $value->id;
            $studentclass->save();
        }

        $record['successlist'] = $successlist;
        $record['errorlist'] = $errorlist;
        $record['warninglist'] = $warninglist;

        return $record;
    }

    public function removestudent(Request $request){
        $student_id = $request['student_id'];
        $class_id   = $request['class_id'];

        $studentinclass = StudentClass::where('student_id','=',$student_id)
                                      ->where('class_id','=',$class_id)
                                      ->delete();
        $record[1] = $student_id;
        $record[2] = $class_id;
        return $record;
    }


}
