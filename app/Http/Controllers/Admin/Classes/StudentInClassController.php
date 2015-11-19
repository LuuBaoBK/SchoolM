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
        $record['id']   = $id;
        $record['name'] = $name;
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
                                                   ->wherE('classname','like',$name)
                                                   ->get())
                                  ->where('ispassed','like',$isPassed)
                                  ->get();
        }
        else{
            $record = StudentClass::whereIn('class_id',
                                            Classes::select('id')
                                                   ->where('id','like',$id)
                                                   ->wherE('classname','=',$classname)
                                                   ->get())
                                    ->where('ispassed','like', $isPassed)
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
