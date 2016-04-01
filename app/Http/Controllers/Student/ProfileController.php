<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Student;
use App\Model\Subject;
use App\User;
use Validator;
use App\Model\StudentClass;

class ProfileController extends Controller
{
    public function get_stu_dashboard(){
        $user = Auth::user();
        $student = Student::find($user->id);
        $student->user;
        if($student->user->dateofbirth != "0000-00-00")
        {
            $mydateofbirth = date_create_from_format("Y-m-d", $student->user->dateofbirth);
            $mydateofbirth = date_format($mydateofbirth,"d/m/Y");
        }
        else{
            $mydateofbirth = "N/A";
        }
        $student['mydateofbirth'] = $mydateofbirth;

        $scholastic = substr(date("Y"), 2,2);
        $scholastic = (date("m") < 8 ) ? $scholastic-1 : $scholastic;
        $check = StudentClass::where('student_id','=',$student->id)
                             ->where('class_id','like', $scholastic."_%")
                             ->first();
        if($check == null){
            $student->nowClass = "no placement";
        }
        else{
            $student->nowClass = $check->class_id;
        }
    return view('studentpage.dashboard')->with('student',$student);
    }

    public function edit_info(Request $request){
        $id = $request['id'];
        $user  = User::find($id);

            $rules = array(
                'firstname'     => 'max:20',
                'middlename'    => 'max:20',
                'lastname'      => 'max:20',
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
        return view('studentpage.permission_denied');
    }   
}
