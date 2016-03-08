<?php

namespace App\Http\Controllers\Teacher\Transcript;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\StudentClass;
use App\User;
use App\Model\Phancong;
use App\Model\Teacher;
use App\Model\Scoretype;
use Excel;
use Storage;
use Auth;
use Input;
use Validator;
use App\Transcript;  
use DB;

class TranscriptController extends Controller
{
    public function view()
    {        
        $class_list =[];
        $grade = "";
        return view('teacherpage.transcript.template', ['class_list' => $class_list, 'grade' => $grade]);
    }

    public function sort($grade){
        $original_grade = $grade;
        if($grade == 'all'){
            $grade = "_%";
        }
        else{
            $grade = "_".$grade."%";
        }
        $user = Auth::user();
        $teacher = Teacher::find($user->id);
        $year = date("Y");
        $month = date("m");
        if($month <= 8){
            $year = $year - 1;
        }
        $year = substr($year, 2);
        $class_id_list = Phancong::select('class_id')
                                      ->where('teacher_id','=',$teacher->id)
                                      ->where('class_id','like',$year.$grade)
                                      ->get();
        $class_list = Classes::whereIn('id',$class_id_list)->get();
        //Add Scoretype for each class
        foreach ($class_list as $key => $value) {
            //Score type 
            $scoretype_list = Scoretype::where('subject_id','=',$teacher->group)
                                        ->where('applyfrom','<=',$year)
                                        ->where('disablefrom','>=',$year)
                                        ->where('disablefrom','<>',DB::raw('applyfrom'))
                                        ->where('month','=',$value->doable_month)
                                        ->get();
            $studentId_list = StudentClass::select('student_id')->where('class_id','=',$value->id)->get();
            //Add status for each scoretype     
            foreach ($scoretype_list as $scoretype_key => $scoretype) {
                $check = Transcript::whereIn('student_id',$studentId_list)
                                    ->where('scoretype_id','=',$scoretype->id)
                                    ->where('scholastic','=',$year)
                                    ->first();
                if($check == null){
                    $scoretype_list[$scoretype_key]['status'] = "new";
                }
                else{
                    $scoretype_list[$scoretype_key]['status'] = "imported";
                }
            }
            $class_list[$key]['score_type_list'] = $scoretype_list;

            //duration
            $from = explode("-", $value->doable_from);
            $to = explode("-", $value->doable_to);
            $class_list[$key]['duration'] = $from[2]."/".$from[1]." ~ ".$to[2]."/".$to[1] ;
            $date = date('Y-m-d');
            $to_date = date_create($date);
            $doable_from = date_create($value->doable_from);
            $doable_to = date_create($value->doable_to);
            $diff1 = date_diff($to_date,$doable_from);
            $diff2 = date_diff($to_date,$doable_to);
            if($diff1->invert == 1 || $diff1->days == 0){
                if($diff2->invert == 0){
                    $class_list[$key]['addclass'] = "enable";
                }
                else{
                    $class_list[$key]['addclass'] = "missing";
                }
            }
            else{
                $class_list[$key]['addclass'] = "waiting";
            }                      
        }
        return view('teacherpage.transcript.template', ['class_list' => $class_list, 'grade' => $original_grade]);
    }

    public function download($class_id){
        $class = Classes::find($class_id);
        $class_name = $class->scholastic."_".$class->classname;
        $user = Auth::user();
        $data = array('user_fullname' => $user->fullname, 'class_id' => $class_id);
        $my_excel = Excel::create($class_name, function($excel) use($data) {
            // Set the title
            $excel->setTitle('Transcript');
            // Chain the setters
            $excel->setCreator($data['user_fullname'])
                  ->setCompany('Schoolm');
            // Call them separately
            $excel->setDescription('Transcript');

            // first sheet
            $excel->sheet('Transcript', function($sheet) use($data) {
                $class_id = $data['class_id'];
                $sheet->setFitToHeight('true');
                $sheet->setFitToWidth('true');
                $col1 = StudentClass::select('student_id')->where('class_id','=',$class_id)->get();
                $col2 = User::select('fullname')->whereIn('id',$col1)->get();
                $heading = array('Id','Full Name','Score','Note');
                $sheet->fromArray($heading, null, 'A1', true, false);
                foreach ($col1 as $key => $value) {
                    $sheet->row($key+2, array( $col1[$key]['student_id'], $col2[$key]['fullname'] ));
                }
            });
        });
        $my_excel->export('xlsx');
    }

    public function import_file(Request $request){
        $input = Input::all();
        $file = array_get($input,'fileToUpload');
        $extension = $file->getClientOriginalExtension();
        $record = Excel::load($file->getRealPath(), function($reader) {}, 'UTF-8')->get();
        //Check Import File
        //check key
        $key_missing = [];
        $key_list = [];
        $error_list = [];
        $data = [];
        foreach ($record[0] as $key => $value) {
            $key_list[$key] = $key;
        }
        if(!array_key_exists('id', $key_list)){
            $key_missing['id'] = 'id';
        }
        if(!array_key_exists('score', $key_list)){
            $key_missing['score'] = 'score';
        }
        if(!array_key_exists('note', $key_list)){
            $key_missing['note'] = 'note';
        }
        if(count($key_missing) > 0){
            $error_list['key_missing'] = 'Key Missing';
            $data['key_missing'] = $key_missing;
        }

        //check number of import row
        $class_id = $input['import_class_hidden'];
        $scoretype_id = $input['import_type_hidden'];
        $student_import_id = [];
        foreach ($record as $key => $value) {
            if($value['id'] != null){
                array_push($student_import_id, $value['id']);
            }
        }
        $student_not_import = StudentClass::select('student_id')
                                        ->where('class_id','=',$class_id)
                                        ->whereNotIn('student_id',$student_import_id)
                                        ->get();
        if(count($student_not_import) > 0){
            $error_list['row_missing'] = 'Row Missing';
            $student_not_import_full = User::whereIn('id',$student_not_import)->get();
            $data['row_missing'] = $student_not_import_full; 
        }
        else{
            //do nothing
        }
        $student_count      = StudentClass::select('student_id')
                                        ->where('class_id','=',$class_id)
                                        ->count();
        $student_import_count = count($student_import_id);
        $count =  $student_import_count - $student_count;
        if($count > 0){
            $error_list['row_redundancy'] = 'Row Redundancy';
            $data['row_redundancy'] = $count;
        }

            if(count($error_list) > 0){
            $data['error_list'] = $error_list;
            return $data;
        }

        // //Pass 3 test (key , row_missing , row_redundancy) 
        $pattern = '/^[0-1]{0,1}[0-9](\.{1}\d{1,2})?$/';
        foreach ($record as $key1 => $row) {
            if(!preg_match($pattern, $row['score'])){
                $record[$key1]['score'] = 11;
            }
            if($row['score'] > 10){
                $record[$key1]['score'] = 11;
            }
            if(strlen($row['note']) > 100){
                $record[$key1]['note'] = substr($row['note'], 0,100);
            }
         }
        return $record;
    }

    public function save_transcript(Request $request){
        $temp = explode('|', $request['class_n_type']);
        $class_id = $temp[0];
        $scoretype_id = $temp[1];
        $subject_id = Teacher::find(Auth::user()->id)->group;
        $scholastic = substr($class_id, 0,2);
        $data = $request['data'];
        foreach ($data as $key => $value) {
           $score = new Transcript;
           $score->student_id = $value[0];
           $score->scholastic = $scholastic;
           $score->subject_id = $subject_id;
           $score->scoretype_id = $scoretype_id;
           $score->score = $value[2];
           $score->note = $value[3];
           $score->save();
        }
        $record = "success";
        return $record;
    }

    public function get_transcript(Request $request){
        $scholastic = substr($request['class_id'], 0,2);
        $student_id_list = StudentClass::select('student_id')
                                       ->where('class_id','=',$request['class_id'])
                                       ->get();
        $data = Transcript::whereIn('student_id',$student_id_list)
                          ->where('scholastic','=',$scholastic)
                          ->where('scoretype_id','=',$request['scoretype_id'])
                          ->get();
        foreach ($data as $key => $value) {
            $fullname = User::find($value->student_id)->fullname;
            $data[$key]['full_name'] = $fullname;
        }
        return $data;
    }

    public function edit_transcript(Request $request){
        $temp = explode('|', $request['class_n_type']);
        $class_id = $temp[0];
        $scoretype_id = $temp[1];
        $subject_id = Teacher::find(Auth::user()->id)->group;
        $scholastic = substr($class_id, 0,2);
        $data = $request['data'];
        $scholastic = substr($class_id, 0,2);
        foreach ($data as $key => $value) {
           $score = Transcript::where('scholastic','=',$scholastic)
                              ->where('student_id','=',$value[0])
                              ->where('scoretype_id','=',$scoretype_id)
                              ->update(['score' => $value[2], 'note' => $value[3] ]);
        }
        $record = "success";
        return $record;
    }

    public function view_transcript(){
        $subject_id = Teacher::find(Auth::user()->id)->group;
        $scoretype_list= Scoretype::where('subject_id','=',$subject_id);
        return view('teacherpage.transcript.view_transcript');
    }
}
