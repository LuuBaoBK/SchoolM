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

class StudentInClassController extends Controller
{
    //
    
    public function view(){
        return view("adminpage.class.studentclassinfo");
    }

    public function updateclassname(Request $request){
        $id = $request['scholastic']."_%";
        $name = "";
        if($request['grade'] == 0){
            $name = "%".$request['group']."%";
        }
        else{
            $name = $request['grade'].$request['group'].'%';
        }
        
        $classname = Classes::where('id','like',$id)->where('classname','like',$name)->get();
        $count = Classes::where('id','like', $id)->where('classname','like',$name)->count();
        $record['count'] = $count;
        $record['data'] = $classname;
        return $record;
    }

    public function showclass(Request $request){
        $class = Classes::where('id','like',$request['scholastic']."_%")
                            ->where('classname','=',$request['classname'])
                            ->first();
        if($request['isPassed'] == -1){
            $record = StudentClass::where('class_id','=',$class->id)->get();
        }
        elseif($request['isPassed'] == 0){
            $record = StudentClass::where('class_id','=',$class->id)
                                    ->where('ispassed','=','0')
                                    ->get();
        }
        else{
            $record = StudentClass::where('class_id','=',$class->id)
                                    ->where('ispassed','=','1')
                                    ->get();
        }
        foreach ($record as $key => $value) {
            $value->student->user;
        }
        return $record;
    }

    public function filterstudent(){

        $display = "";
        $student = "";
        $postedit = Input::all();
        $hocky = $postedit['hocky'];
        $khoi = $postedit['khoi'];
        
        $idclass = Classes::where('scholastic', '=', $hocky)->where('classname','like',"$khoi%")->get();
        foreach($idclass as $row){

            $sts = $row->students;
            foreach ($sts as $key) {
                $student = $key->student->user;
                $display .="<tr>
                                <td>$student->id</td>
                                <td>$student->firstname $student->middlename $student->lastname</td>
                                <td>
                                <a data-id ='$student->id' class='addStudentIntoClass'>Add</a> 
                            </td>
                            </tr>";
            }
            
        }

        return $display;
    }

    public function getclass(){

        $display = "";
        $postedit = Input::all();
        $id = $postedit['id'];
        $idclass = Classes::find($id);
        $sts = $idclass->students;
        foreach ($sts as $key) {
            $student = $key->student->user;
            $display .="<tr>
                            <td>$student->id</td>
                            <td>$student->firstname $student->middlename $student->lastname</td>
                            <td>
                            <a data-id ='$student->id' href='#' class='removeStudentFromClass'>Remove</a>
                            </td>
                        </tr>";
        }

        return $display;
    }

    public function addStudent()
    {
        $poststudent = Input::all();
        $newrecord = new StudentClass;
        $newrecord->student_id = $poststudent['student_id'];
        $newrecord->class_id   = $poststudent['class_id'];
        $check = $newrecord->save();

        if($check)
        {
            return 0;
        }
        else
        {
            return 1;
        }
        
    }


    public function removeStudent()
    {
        $poststudent = Input::all();
        $student_id = $poststudent['student_id'];
        $class_id   = $poststudent['class_id'];
        $del = StudentClass::where('student_id',$student_id)->where('class_id',$class_id);
        $check = $del->delete();

        if($check)
        {
            return 0;
        }
        else
        {
            return 1;
        }
        
    }

}
