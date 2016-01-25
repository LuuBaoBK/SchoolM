<?php

namespace App\Http\Controllers\Admin\UserManage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Subject;
use App\Model\Student;
use App\Model\Parents;
use App\Model\Sysvar;
use Input;
use Validator;


class TeacherManageController extends Controller
{
    public function get_view(){
        $subject_list = Subject::all();
        return view('adminpage.usermanage.adduser_te')->with('subject_list',$subject_list);
    }

    public function search_te(Request $request){
        $fullname = "%".$request['fullname']."%";
        $group = $request['group'];
        if($request['group'] == "-1"){
            $teacher_list = Teacher::select('id')->get();
        }
        else{
            $teacher_list = Teacher::select('id')->where('group','=',$group)->get();
        }
        if($fullname != "")
            $record = User::whereIn('id',$teacher_list)->where('fullname','LIKE',$fullname)->get();
        else
            $record = User::whereIn('id',$teacher_list)->get();
        foreach ($record as $key => $value) {
            $value->teacher->my_position;
        }
        return $record;
    }

    public function store_te(Request $request)
    {
        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'address'       => 'max:120',
            'homephone'     => 'digits_between:10,11',
            'mobilephone'   => 'digits_between:10,11',
            'dateofbirth'   => 'date_format:d/m/Y',
            'incomingday'   => 'date_format:d/m/Y',
            'specialized'   => 'max:20',
            'position'      => 'max:20',            
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $user = new User;
            $teacher = new Teacher;
            //Create ID
            $te_next_id = Sysvar::find('t_next_id');
            $te_next_id->value = $te_next_id->value + 1;
            $id = $te_next_id->value;
            $offset = strlen($id);
            $newid = "0000000";
            $newid = substr($newid,$offset);
            $newid = "t_".$newid.$id;
            //Handle Date Format
            if($request['dateofbirth'] != "")
            {
                $dateofbirth = date_create_from_format("d/m/Y", $request['dateofbirth']);
                $dateofbirth = date_format($dateofbirth,"Y-m-d");
            }
            else{
                $dateofbirth = $request['dateofbirth'];
            }


            if($request['incomingday'] != "")
            {
                $incomingday = date_create_from_format("d/m/Y", $request['incomingday']);
                $incomingday = date_format($incomingday,"Y-m-d");
            }
            else{
                $incomingday = $request['incomingday'];
            }

            //Create Email & Password
            $email = $newid."@schoolm.com";
            //$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $password = $newid;

            // Create User
            $user->id = $newid;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->firstname = $request['firstname'];
            $user->middlename = $request['middlename'];
            $user->lastname = $request['lastname'];
            $user->fullname = $request['firstname']." ".$request['middlename']." ".$request['lastname'];
            $user->address = $request['address'];
            $user->role = "1";
            $user->dateofbirth = $dateofbirth;
            $user->save();

            $teacher->id = $newid;
            $teacher->mobilephone = $request['mobilephone'];
            $teacher->homephone = $request['homephone'];
            $teacher->group = $request['group'];
            $teacher->position = $request['position'];
            $teacher->specialized = $request['specialized'];
            $teacher->incomingday = $incomingday;
            $teacher->save();

            $te_next_id->save();

            $teacher = Teacher::find($newid);
            $teacher->user;
            $record = array
            (
                'button'        => "<a href='/admin/manage-user/teacher/edit/$newid' ><i class = 'glyphicon glyphicon-edit'></i></a>",
                'isDone'       => 1,
                'mydata'        => $teacher
            );

            
            $record['mydata'] = $teacher;
            return $record;
        }
    }

    public function get_edit_form($id)
    {
        $teacher = Teacher::find($id);
        if($teacher->user->dateofbirth == "0000-00-00"){
            $dateofbirth = "";
        }
        else
        {
            $dateofbirth = date_create($teacher->user->dateofbirth);
            $dateofbirth = date_format($dateofbirth, "d/m/Y");
        }

        if($teacher->incomingday == "0000-00-00"){
            $incomingday = "";
        }
        else
        {
            $incomingday = date_create($teacher->incomingday);
            $incomingday = date_format($incomingday, "d/m/Y");
        }
            
        $teacher['mydateofbirth'] = $dateofbirth;
        $teacher['myincomingday'] = $incomingday;
        $group = Subject::all();
        return view('adminpage.usermanage.edit_te',['teacher' => $teacher, 'group' => $group]);
    }

    public function edit_te(Request $request){
        $id = $request['id'];
        $user  = User::find($id);
        $teacher = Teacher::find($id);

        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'address'       => 'max:120',
            'homephone'     => 'digits_between:10,11',
            'mobilephone'   => 'digits_between:10,11',
            'dateofbirth'   => 'date_format:d/m/Y',
            'incomingday'   => 'date_format:d/m/Y',
            'specialized'   => 'max:20',
            'position'      => 'max:20'
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

           if($request['incomingday'] != "")
            {
                $incomingday = date_create_from_format("d/m/Y", $request['incomingday']);
                $incomingday = date_format($incomingday,"Y-m-d");
            }
            else{
                $incomingday = $request['incomingday'];
            }

            $user->firstname = $request['firstname'];
            $user->middlename = $request['middlename'];
            $user->lastname = $request['lastname'];
            $user->fullname = $request['firstname']." ".$request['middlename']." ".$request['lastname'];
            $user->address = $request['address'];
            $user->dateofbirth = $dateofbirth;
            $user->save();

            $teacher->mobilephone = $request['mobilephone'];
            $teacher->homephone = $request['homephone'];
            $teacher->group = $request['group'];
            $teacher->position = $request['position'];
            $teacher->specialized = $request['specialized'];
            $teacher->incomingday = $incomingday;

            $teacher->save();

            $record['isDone'] = 1;
            return $record;
        }
    }

    public function reset_password($id){
        $teacher = Teacher::find($id);
        $teacher->user;
        $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $teacher->user->password = bcrypt($password);
        $teacher->user->save();
        if($teacher->user->dateofbirth == "0000-00-00"){
            $dateofbirth = "";
        }
        else
        {
            $dateofbirth = date_create($teacher->user->dateofbirth);
            $dateofbirth = date_format($dateofbirth, "d/m/Y");
        }
        return view('adminpage.usermanage.print_te', ['teacher' => $teacher, 'password' => $password, 'dateofbirth' => $dateofbirth]);
    }
}
