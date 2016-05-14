<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Teacher;
use App\Model\Subject;
use App\User;
use Validator;
use App\Model\Classes;
use Input;

class ProfileController extends Controller
{
    public function get_te_dashboard(){
    	$user = Auth::user();
        $teacher = Teacher::find($user->id);
        $teacher->user;
        if($teacher->user->dateofbirth != "0000-00-00")
        {
            $mydateofbirth = date_create_from_format("Y-m-d", $teacher->user->dateofbirth);
            $mydateofbirth = date_format($mydateofbirth,"d/m/Y");
        }
        else{
            $mydateofbirth = "N/A";
        }
        if($teacher->incomingday != "0000-00-00")
        {
            $myincomingday = date_create_from_format("Y-m-d", $teacher->incomingday);
            $myincomingday = date_format($myincomingday,"d/m/Y");
        }
        else{
            $myincomingday = "N/A";
        }

        $teacher['mydateofbirth'] = $mydateofbirth;
        $teacher['myincomingday'] = $myincomingday;
        $teacher->group = Subject::find($teacher->group)->subject_name;
        $year = substr(date("Y"),2,2);
        $year = (date("m") < 8) ? ($year - 1) : $year;
        $homeroom_class = Classes::where('homeroom_teacher','=',$teacher->id)->where('id','like',$year."_%")->first();
        if($homeroom_class == null){
            $homeroom_class = "N/A";
        }
        else{
            $homeroom_class = $homeroom_class->classname;
        }
        return view('teacherpage.dashboard',['teacher' => $teacher, 'homeroom_class' => $homeroom_class]);
    }

    public function edit_info(Request $request){
        $id = $request['id'];
        $user  = User::find($id);
        $teacher = Teacher::find($id);

            $rules = array(
                'firstname'     => 'max:20',
                'middlename'    => 'max:20',
                'lastname'      => 'max:20',
                'mobilephone'   => 'digits_between:10,11',
                'homephone'     => 'digits_between:10,11',
                'dateofbirth'   => 'date_format:d/m/Y',
                'address'       => 'max:120'
            );

            $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {

            if($request['dateofbirth'] != "")
            {
                $dateofbirth = date_create_from_format("d/m/Y", $request['dateofbirth']);
                $dateofbirth = date_format($dateofbirth,"Y-m-d");
            }
            else{
                $dateofbirth = $request['dateofbirth'];
            }

            $user->firstname   = $request['firstname'];
            $user->middlename  = $request['middlename'];
            $user->lastname    = $request['lastname'];
            $user->dateofbirth = $dateofbirth;
            $user->address     = $request['address'];
            $user->fullname    = $request['firstname']." ".$request['middlename']." ".$request['lastname'];

            $user->save();
            $teacher->mobilephone = $request['mobilephone'];
            $teacher->homephone = $request['homephone'];
            $teacher->save();

            $record['isDone'] = 1;
            return $record;
        }
    }

    public function changepassword(Request $request){
        $new_password = $request['new_password'];
        $confirm_password = $request['confirm_password'];

        $rules = array(
            'new_password'     => 'required|max:60|min:4',
            'confirm_password' => 'required|max:60|min:4|same:new_password'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $new_password = bcrypt($new_password);
            $user = User::find(Auth::user()->id);
            $user->password = $new_password;
            $user->save();
            $record['isSuccess'] = '1';
            return $record;
        }
    }

    public function upload_image(Request $request){
        $input = Input::all();
        $file = array_get($input,'fileToUpload');
        $extension = $file->getClientOriginalExtension();
        $validator = Validator::make($request->all(), [
            'fileToUpload' => 'required|max:1000',
        ]);
        if($validator->fails()){
            $record = $validator->messages();
            return $record;
        }
        else{
            $id = Auth::user()->id;
            $destinationPath = 'uploads\teachers\\'; // upload path
            $temp = $destinationPath.$id;
            if(file_exists(".\\".$temp.".jpg")){
                unlink($temp.".jpg");
            }
            if(file_exists(".\\".$temp.".png")){
                unlink($temp.".png");
            }
            $fileName = $id.'.'.$extension; // renameing image
            $file->move($destinationPath, $fileName); // uploading file to given path
        }
        return $request['fileToUpload'];
    }

    public function permission_denied(){
        return view('teacherpage.permission_denied');
    }	
}
