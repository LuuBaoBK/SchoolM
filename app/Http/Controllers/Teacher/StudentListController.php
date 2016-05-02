<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Classes;
use App\Model\Phancong;
use App\Model\StudentClass;

class StudentListController extends Controller
{
    public function get_view(){
        $year = substr(date("Y"),2,2);
        $year = (date("m") < 8) ? $year-1 : $year;
        $year .= "%";
        $class_list = Classes::whereIn('id',
                                        Phancong::select('class_id')
                                                ->where('teacher_id','=',Auth::user()->id)
                                                ->where('class_id','like',$year)
                                                ->get()
                                        )
                                ->get();
        foreach ($class_list as $key => $class) {
            $total = StudentClass::where('class_id','=',$class->id)->count();
            $class_list[$key]->total = $total;
            $class->teacher->user;
        }
        return view('teacherpage.studentlist',['class_list' => $class_list]);
    }

    public function get_student_list(Request $request){
        $user = Auth::user();
        $class = Classes::find($request['id']);
        $studentlist = StudentClass::where('class_id','=',$class->id)->get();
        foreach ($studentlist as $key => $student) {
            $student->student->user;
            $student->student->parent->user;
        }
        $data['teacher'] = $class->teacher->user;
        $data['studentlist'] = $studentlist;
        return $data; 
    }
}
