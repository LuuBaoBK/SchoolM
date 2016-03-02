<?php

namespace App\Http\Controllers\Teacher\Transcript;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\StudentClass;
use App\User;
use App\Model\Classteacher;
use App\Model\Teacher;
use App\Model\Scoretype;
use Excel;
use Storage;
use Auth;
use Input;
use Validator;
use App\Transcript;  

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
        $class_id_list = Classteacher::select('class_id')
                                      ->where('teacher_id','=',$teacher->id)
                                      ->where('class_id','like',$year.$grade)
                                      ->get();
        $class_list = Classes::whereIn('id',$class_id_list)->get();
        //Add Scoretype for each class
        foreach ($class_list as $key => $value) {
            //Score type 
            $scoretype_list = Scoretype::where('subject_id','=',$teacher->group)
                                        ->where('applyfrom','<=','15')
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
                $heading = array('Id','Full Name','Score_15', 'Score_45', 'Score_GK ', 'Score_CK', 'Note');
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
        // $user = Auth::user();
        // $class_id = array_get($input,'import_text_hidden');
        // $class_id = str_replace(".xlsx","",$class_id);
        // $year = "20".substr($class_id, 0, 2);
        // $destinationPath = 'uploads\\'.$user->id.'\\'.$year."\\".$class_id;
        // $date = date("Y_d_m");
        // $time = date("h_i");
        // $filename = $class_id."_".$date."_".$time.".xlsx";
        // $upload_success = $file->move($destinationPath, $filename );
        // $record = "";
        $record = Excel::load($file->getRealPath(), function($reader) {}, 'UTF-8')->get();
        $pattern = '/^[0-1]{0,1}[0-9](\.{1}\d{1,2})?$/';
        foreach ($record as $key1 => $row) {
            if(!preg_match($pattern, $row['score_15'])){
                $record[$key1]['score_15'] = 0;
            }
            if(!preg_match($pattern, $row['score_45'])){
                $record[$key1]['score_45'] = 0;
            }
            if(!preg_match($pattern, $row['score_gk'])){
                $record[$key1]['score_gk'] = 0;
            }
            if(!preg_match($pattern, $row['score_ck'])){
                $record[$key1]['score_ck'] = 0;
            }
         }
        return $record;
    }

    public function save_transcript(Request $request){
        $data = $request['data'];
        $class_id = $request['id'];
        return $record;
    }
}
