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
        $input_month = $request['input_month'];
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
            $to_date = date_create_from_format("d/m/Y", $request['to_date']);
            $to_date = date_format($to_date,"Y-m-d");
            $from_date = date_create_from_format("d/m/Y", $request['from_date']);
            $from_date = date_format($from_date,"Y-m-d");
            foreach ($classes as $key => $value) {
                $value->update(['doable_month' => $input_month, 'doable_from' => $from_date, 'doable_to' => $to_date]);
            }
            $record['isSuccess'] = 1;
            $record['data'] = $classes;
            return $record;
        }
    }
}