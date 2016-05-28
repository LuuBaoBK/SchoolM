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
use App\Model\Schedule;
use Excel;
use Storage;
use Auth;
use Input;
use Validator;
use App\Transcript;  
use DB;
use App\Model\Subject;
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
        if($month < 8){
            $year = $year - 1;
        }
        $year = substr($year, 2);
        $class_id_list = Schedule::select('class_id')
                                ->where('class_id','like',$year.$grade)
                                ->where('teacher_id','=',$teacher->id)
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
            // $pusher = App::make('pusher');
            // $pusher->trigger( $value[0]."-chanel",
            //               'new_score_event', 
            //               Subject::find($subject_id)->subject_name)." import score: ".Scoretype::find($scoretype_id)->type;
        }
        $record = "success";
        return $record;
    }

    public function get_transcript(Request $request){
        $scholastic = substr($request['class_id'], 0,2);
        $student_id_list = StudentClass::where('class_id','=',$request['class_id'])
                                       ->get();
        $data = array();
        foreach ($student_id_list as $key => $student) {
            $student_score = Transcript::where('student_id','=',$student->student_id)
                              ->where('scholastic','=',$scholastic)
                              ->where('scoretype_id','=',$request['scoretype_id'])
                              ->first();
            if($student_score == null){
                $temp['full_name'] = User::find($student->student_id)->fullname;
                $temp['score'] = 19;
                $temp['note'] = "";
                $temp['student_id'] = $student->student_id;
                array_push($data, $temp);
            }
            else{
                $student_score->full_name = User::find($student->student_id)->fullname;
                array_push($data, $student_score);
            }
        // }
        // $data = Transcript::whereIn('student_id',$student_id_list)
        //                   ->where('scholastic','=',$scholastic)
        //                   ->where('scoretype_id','=',$request['scoretype_id'])
        //                   ->get();
        // foreach ($data as $key => $value) {
        //     $fullname = User::find($value->student_id)->fullname;
        //     $data[$key]['full_name'] = $fullname;
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
            $check = Transcript::where('scholastic','=',$scholastic)
                              ->where('student_id','=',$value[0])
                              ->where('scoretype_id','=',$scoretype_id)
                              ->first();
            if($check == null){
                $new = new Transcript;
                $new->student_id = $value[0];
                $new->scholastic = $scholastic;
                $new->subject_id = $subject_id;
                $new->scoretype_id = $scoretype_id;
                $new->score = $value[2];
                $new->note = $value[3];
                $new->save();
            }
            else{
                $check = Transcript::where('scholastic','=',$scholastic)
                                  ->where('student_id','=',$value[0])
                                  ->where('scoretype_id','=',$scoretype_id)
                                  ->update(['score' => $value[2], 'note' => $value[3]]);
            }
        }
        $record = "success";
        return $record;
    }

    public function view_transcript(){
        //installizing data
        $teacher = Teacher::find(Auth::user()->id);
        $year = substr(date("Y"), 2,2);
        $year = (date("m") < 8) ? $year-1 : $year;
        $subject_id = Teacher::find(Auth::user()->id)->group;
        $class_list = Schedule::select('class_id')
                              ->where('teacher_id','=',$teacher->id)
                              ->where('class_id','like',$year."_%")
                              ->get();
        $class_list = Classes::whereIn('id',$class_list)->get();
        foreach ($class_list as $key => $value) {
            $value->teacher->user;
        }
        return view('teacherpage.transcript.view_transcript',['class_list' => $class_list]);
    }

    public function view_transcript_get_class(Request $request){
        $scholastic = $request['scholastic'];
        $grade      = $request['grade'];
        if($grade == 0){
            $grade = "_%";
        }
        else{
            $grade = "_".$grade."_%";
        }
        $teacher_id = Auth::user()->id;
        $subject_id = Teacher::find(Auth::user()->id)->group;
        $class_list = Schedule::select('class_id')
                              ->where('teacher_id','=',$teacher_id)
                              ->where('class_id','like',$scholastic.$grade)
                              ->get();
        $class_list = Classes::whereIn('id',$class_list)->get();
        foreach ($class_list as $key => $value) {
            $value->teacher->user;
        }
        return $class_list;
    }

    public function view_transcript_get_score(Request $request){
        $class_id = $request['class_id'];
        $scholastic = substr($class_id, 0, 2);
        $teacher = Teacher::find(Auth::user()->id);
        $subject = subject::find($teacher->group);
        $student_list = StudentClass::where('class_id','=',$class_id)
                                    ->get();
        foreach ($student_list as $student_list_key => $student) {
            //Add Score
            $student_score = [];
            $hk1_average = 0;
            $hk2_average = 0;
            $scholastic_average = 0;

            $hk_factor_total = 1;
            for($i=8;$i<=12;$i++){
                $month_average = 0;
                $month_factor_total = 0;
                $scoretype_list = Scoretype::where('subject_id','=',$teacher->group)
                                    ->where('applyfrom','<=',$scholastic)
                                    ->where('disablefrom','>=',$scholastic)
                                    ->where('month','=',$i)
                                    ->get();
                if(count($scoretype_list) != 0){
                    foreach ($scoretype_list as $scoretype_key => $scoretype) {
                        $hk_factor_total += $scoretype->factor;
                        $month_factor_total += $scoretype->factor;
                        $score = Transcript::where('scholastic','=',$scholastic)
                                            ->where('student_id','=',$student->student_id)
                                            ->where('scoretype_id','=',$scoretype->id)
                                            ->first();
                        if(count($score) != 0){
                            $real_score = ($score->score > 10) ? 0 : $score->score;
                            $month_average += $real_score * $scoretype->factor;
                            $hk1_average += $real_score * $scoretype->factor;
                            $month_average = $month_average / $month_factor_total;
                            $student_score['month_'.$i][$scoretype->type] = $score->score;
                        }
                        else{
                            $student_score['month_'.$i][$scoretype->type] = "13";
                        }
                    }
                    $student_score['month_'.$i]['month_average'] = number_format($month_average,2);
                }
            }
            $hk1_average = $hk1_average / $hk_factor_total;
            
            $hk_factor_total = 1;
            for($i=1;$i<=5;$i++){
                $month_average = 0;
                $month_factor_total = 0;
                $scoretype_list = Scoretype::where('subject_id','=',$teacher->group)
                                    ->where('applyfrom','<=',$scholastic)
                                    ->where('disablefrom','>=',$scholastic)
                                    ->where('month','=',$i)
                                    ->get();
                if(count($scoretype_list) != 0){
                    foreach ($scoretype_list as $scoretype_key => $scoretype) {
                        $hk_factor_total += $scoretype->factor;
                        $month_factor_total += $scoretype->factor;
                        $score = Transcript::where('scholastic','=',$scholastic)
                                            ->where('student_id','=',$student->student_id)
                                            ->where('scoretype_id','=',$scoretype->id)
                                            ->first();
                        if(count($score) != 0){
                            $real_score = ($score->score > 10) ? 0 : $score->score;
                            $month_average += $real_score * $scoretype->factor;
                            $hk2_average += $real_score * $scoretype->factor;
                            $month_average = $month_average / $month_factor_total;
                            $student_score['month_'.$i][$scoretype->type] = $score->score;
                        }
                        else{
                            $student_score['month_'.$i][$scoretype->type] = "13";
                        }
                    }
                    $student_score['month_'.$i]['month_average'] = number_format($month_average,2);
                }
            }
            $hk2_average = $hk2_average / $hk_factor_total;

            $scholastic_average = $hk1_average + 2*$hk2_average / 3;
            $student_score['hk1_average'] = number_format($hk1_average,2);
            $student_score['hk2_average'] = number_format($hk2_average,2);
            $student_score['scholastic_average'] = number_format($scholastic_average,2);
            $student_list[$student_list_key]['score_list'] = $student_score;

            //Add Name
            $fullname = User::find($student->student_id)->fullname;
            $student_list[$student_list_key]['fullname'] = $fullname;
        }
        return $student_list;
    }
}
