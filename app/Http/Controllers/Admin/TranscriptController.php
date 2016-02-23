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
use Validator;

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
        return view('adminpage.transcript_general');
    }

    public function updateclassname(Request $request){
        $scholastic = $request['scholastic'];
        $grade      = $request['grade'];

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

        $name .= "%";
        
        $classname = Classes::where('id','like',$id)->where('classname','like',$name)->get();
        $record = $classname;
        return $record;
    }

    public function set_time(Request $request){
        $class_list = $request['class_list'];
        $to_date    = $request['to_date'];
        $from_date  = $request['from_date'];
        $doable_type = $request['doable_type'];
        $rules = array(
            'to_date'   => 'required|date_format:d/m/Y',
            'from_date'     => 'required|date_format:d/m/Y|before:to_date'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $classes = Classes::whereIn('id',$class_list)->get();
            foreach ($classes as $key => $value) {
                $value->update(['doable_from' => $from_date, 'doable_to' => $to_date, 'doable_type' => $doable_type]);
            }
            $record['isSuccess'] = 1;
            $record['data'] = $classes;
            return $record;
        }
    }
}
