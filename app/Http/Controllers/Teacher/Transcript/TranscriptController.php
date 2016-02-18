<?php

namespace App\Http\Controllers\Teacher\Transcript;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\StudentClass;
use App\User;
use Excel;
use Storage;
use Auth;
use Input;

class TranscriptController extends Controller
{
    public function view()
    {
        return view('teacherpage.transcript.template');
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
        $count = Classes::where('id','like', $id)->where('classname','like',$name)->count();
        $record['count'] = $count;
        $record['data'] = $classname;
        return $record;
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
                $sheet->protect('password');
            });
            $excel->sheet('Info', function($sheet) {
                $sheet->setFitToHeight('true');
                $sheet->setFitToWidth('true');
                $heading = array('Factor','Name');
            });
        });
        $my_excel->export('xlsx');
    }

    public function import_file(Request $request){
       $input = Input::all();
       $file = array_get($input,'fileToUpload');
       $extension = $file->getClientOriginalExtension();
       if($extension != "xlsx"){
        $error = "type_error";
        return $error;
       }
       else{
            $user = Auth::user();
            $class_id = array_get($input,'import_text_hidden');
            $class_id = str_replace(".xlsx","",$class_id);
            $year = "20".substr($class_id, 0, 2);
            $destinationPath = 'uploads\\'.$user->id.'\\'.$year."\\".$class_id;
            $date = date("Y_d_m");
            $time = date("h_i");
            $filename = $class_id."_".$date."_".$time.".xlsx";
            $upload_success = $file->move($destinationPath, $filename );
            $record = "";
            $record = Excel::load($destinationPath."\\".$filename, function($reader) {}, 'UTF-8')->get();
            return $record;
       }
    }

    public function read($fileName){
        Excel::load('public\uploads\\'.$fileName, function($reader) {

            $results = $reader->all();
            $record = $reader->toArray();
            dd($record);

        }, 'UTF-8');
    }
}
