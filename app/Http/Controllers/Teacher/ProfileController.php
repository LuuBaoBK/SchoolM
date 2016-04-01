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
    return view('teacherpage.dashboard')->with('teacher',$teacher);
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

    public function permission_denied(){
        return view('teacherpage.permission_denied');
    }	
}
