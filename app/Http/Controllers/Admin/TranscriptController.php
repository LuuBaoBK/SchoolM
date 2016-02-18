<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transcript;
use App\User;
use App\Model\Student;
use App\Model\Subject;
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
            $kq[$i][1] = $value->student->user->firstname." ".$value->student->user->middlename." ".$value->student->user->lastname;
            $kq[$i][2] = $value->student_id;
            $i++;
        }
        $record = array(
                'isSuccess' => 1,
                'mydata' => $kq
            );
        return $record;
    }

    public function gettranscript(Request $request)
    {
        $id = $request['id'];
        $kq = array();
        $listsubject = Subject::select('id', 'subject_name')->orderBy('subject_name', 'asc')->get();
        $type = Transcript::select('type')->distinct()->orderBy('type', 'asc')->get();
        $i = 0;
        foreach ($listsubject as $key) {
            $kq[$i][0] = $key->subject_name;
            $j=0;
            foreach ($type as $key1) {
                $score = Transcript::select('score')->where('student_id', '=', $id)->where('subject_id', '=', $key->id)->where('type', '=', $key1->type)->first();
                $temp = count($score);
                $j++;
                $kq[$i][$j] = "";
                if ($temp>0)
                    //foreach ($score as $key2) {
                        $kq[$i][$j] = $score->score;
                    //}        
            }
            $i++;
            // $score = Transcript::select('score')->where('student_id', '=', $id)->where('subject_id', $key->id)->orderBy('type', 'asc')->get();
            // $kq[$i][0] = $key->subject_name;
            // $j = 0;
            // foreach ($score as $key1) {
            //     $j++;
            //     $kq[$i][$j] = $key1->score;      
            // }
            // if ($j < $type)
            //     for ($z = $j+1; $z <= $type; $z++)
            //     {
            //         $kq[$i][$z] = "";
            //     }

            // $i++;
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

    public function general_view(Request $request)
    {
        // $transcript = new Transcript;
        // $transcript->semester = $request['semester'];
        // $transcript->student_id = $request['student'];
        // $transcript->subject_id = $request['subject'];
        // $transcript->type = $request['type'];
        // $transcript->score = $request['score'];
        // $transcript->save();
        return view('adminpage.transcript_general');
    }
}
