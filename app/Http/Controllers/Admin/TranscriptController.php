<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transcript;
use App\User;
use App\Model\Student;
use App\Model\Classes;
use App\Model\StudentClass;

class TranscriptController extends Controller
{
    public function index(){
        return view('adminpage.transcript');
    }

    public function getstudent(Request $request)
    {
        $id = $request['classname'];
        $stu = StudentClass::select('student_id')->where('class_id','=', $id)->get();
        $kq = array();
        $i = 1;
        foreach ($stu as $value) {
            $kq[$i] = $value->student->user->firstname." ".$value->student->user->middlename." ".$value->student->user->lastname;
            $i++;
        }
        $record = array(
                'isSuccess' => 1,
                'mydata' => $kq
            );
        return $record;
    }

    public function store(Request $request)
    {
        $transcript = new Transcript;
        $transcript->semester = $request['semester'];
        $transcript->student_id = $request['student'];
        $transcript->subject_id = $request['subject'];
        $transcript->type = $request['type'];
        $transcript->score = $request['score'];
        $transcript->save();
        return Redirect('/admin/transcript');
    }
}
