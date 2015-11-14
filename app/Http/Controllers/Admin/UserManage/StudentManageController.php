<?php

namespace App\Http\Controllers\Admin\UserManage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\Parents;
use App\Model\Sysvar;
use Input;
use Validator;


class StudentManageController extends Controller
{
    public function get_stu(){
        $studentlist = Student::all();
        return view('adminpage.usermanage.adduser_stu', ['studentlist' => $studentlist]);
    }

    public function show(Request $request){
        $rules = array(
            'to_year'     => 'greater_than :from_year'      
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
           $record['isSuccess'] = 0;
            return $record;
        }
        else
        {   
            $student = Student::whereBetween('enrolled_year', [$request['from_year'], $request['to_year']])->orderBy('id','desc')->get();
            foreach ($student as $key => $value) {
                $value->user;
                $value->parent->user;
            }
            $record = array(
                'isSuccess' => 1,
                'mydata' => $student
            );
            $record['isSuccess'] = 1;
            return $record;
        }

        //return view('adminpage.usermanage.adduser_stu', ['studentlist' => $studentlist]);
    }

    public function store_stu(Request $request)
    {   

        $check = $request['createNew'];
        if($check == 'true'){
            $rules = array(
                'student_firstname'   =>  'max:20',  
                'student_middlename'  =>  'max:20',     
                'student_lastname'    =>  'max:20',  
                'student_dateofbirth' =>  'date_format:d/m/Y',    
                'enrolled_year'       =>  'digits_between:1,4',        
                'graduated_year'      =>  'digits_between:1,4', 
                'student_address'     =>  'max:120',
                'parent_firstname'    =>  'max:20',    
                'parent_middlename'   =>  'max:20',   
                'parent_lastname'     =>  'max:20',    
                'parent_dateofbirth'  =>  'date_format:d/m/Y', 
                'parent_mobilephone'  =>  'digits_between:10,11',    
                'parent_homephone'    =>  'digits_between:10,11',  
                'parent_job'          =>  'max:20',  
                'parent_address'      =>  'max:120'  
            );
        }
        else{
            $rules = array(
                'student_firstname'   =>  'max:20',  
                'student_middlename'  =>  'max:20',     
                'student_lastname'    =>  'max:20',  
                'student_dateofbirth' =>  'date_format:d/m/Y',    
                'enrolled_year'       =>  'digits_between:1,4',        
                'graduated_year'      =>  'digits_between:1,4', 
                'student_address'     =>  'max:120',
                'parent_id'           =>  'required|isexistparent' 
            );
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            $record = $validator->messages();
            return $record;
        }
        else
        {
            $s_user = new User;
            $student = new Student;
            //create student id & password
            $s_next_id = Sysvar::find('s_next_id');
            $s_next_id->value = $s_next_id->value + 1;
            $s_id = $s_next_id->value;
            $offset = strlen($s_id);
            $new_s_id = "0000000";
            $new_s_id = substr($new_s_id,$offset);
            $new_s_id = "s_".$new_s_id.$s_id;
            $s_email = $new_s_id."@schoolm.com";
            $s_password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            // handle student date of birth
            if($request['student_dateofbirth'] != "")
            {
                $student_dateofbirth = date_create_from_format("d/m/Y", $request['student_dateofbirth']);
                $student_dateofbirth = date_format($student_dateofbirth,"Y-m-d");
            }
            else{
                $student_dateofbirth = $request['student_dateofbirth'];
            }

            $s_user->id             = $new_s_id; 
            $s_user->email          = $s_email;
            $s_user->password       = $s_password;
            $s_user->firstname      = $request['student_firstname'];
            $s_user->middlename     = $request['student_middlename'];    
            $s_user->lastname       = $request['student_lastname'];
            $s_user->role           = '3';
            $s_user->dateofbirth    = $student_dateofbirth;
            $s_user->address        = $request['student_address'];
            $s_user->save();
            $s_next_id->save();

            if($check == 'true'){ // create new parent account
                $p_user = new User;
                $parent = new Parents;
                //create student id & password
                $p_next_id = Sysvar::find('p_next_id');
                $p_next_id->value = $p_next_id->value + 1;
                $p_id = $p_next_id->value;
                $offset = strlen($p_id);
                $new_p_id = "0000000";
                $new_p_id = substr($new_p_id,$offset);
                $new_p_id = "p_".$new_p_id.$p_id;
                $p_email = $new_p_id."@schoolm.com";
                $p_password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                // handle student date of birth
                if($request['parent_dateofbirth'] != "")
                {
                    $parent_dateofbirth = date_create_from_format("d/m/Y", $request['parent_dateofbirth']);
                    $parent_dateofbirth = date_format($parent_dateofbirth,"Y-m-d");
                }
                else{
                    $parent_dateofbirth = $request['parent_dateofbirth'];
                }

                $p_user->id             = $new_p_id; 
                $p_user->email          = $p_email;
                $p_user->password       = $p_password;
                $p_user->firstname      = $request['parent_firstname'];
                $p_user->middlename     = $request['parent_middlename'];    
                $p_user->lastname       = $request['parent_lastname'];
                $p_user->role           = '4';
                $p_user->dateofbirth    = $parent_dateofbirth;
                $p_user->address        = $request['parent_address'];
                $p_user->save();
                $p_next_id->save();

                $parent->id             = $new_p_id;
                $parent->mobilephone    = $request['parent_mobilephone'];
                $parent->homephone      = $request['parent_homephone'];
                $parent->job            = $request['parent_job'];
                $parent->save();

                $student->parent_id = $new_p_id;
            }
            else{ // use existing parent account
                $student->parent_id = $request['parent_id'] ;
            }

            $student->id             = $new_s_id;
            $student->enrolled_year  = $request['enrolled_year'];
            $student->graduated_year = $request['graduated_year'];
            $student->save();

            $student = Student::find($new_s_id);
            $student->user;
            $student->parent->user;
            $record = $student;
            $record['isSuccess'] = 1;
            return $record;
        } // end else validator fail
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

        if($teacher->user->incomingday == "0000-00-00"){
            $incomingday = "";
        }
        else
        {
            $incomingday = date_create($teacher->user->incomingday);
            $incomingday = date_format($incomingday, "d/m/Y");
        }
            
        $teacher['mydateofbirth'] = $dateofbirth;
        $teacher['myincomingday'] = $incomingday;
        return view('adminpage.usermanage.edit_te')->with('teacher',$teacher);
    }

    public function edit_ad(Request $request){

        $id = $request['id'];
        $user  = User::find($id);
        $teacher = Teacher::find($id);

        $test['isDone'] = 1;
        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'address'       => 'max:120',
            'homephone'     => 'digits_between:10,11',
            'mobilephone'   => 'digits_between:10,11',
            'dateofbirth'   => 'date_format:d/m/Y',
            'incomingday'   => 'date_format:d/m/Y',
            'group'         => 'max:20',
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
            $user->address = $request['address'];
            $user->dateofbirth = $dateofbirth;
            $user->save();

            $teacher->mobilephone = $request['mobilephone'];
            $teacher->homephone = $request['homephone'];
            $teacher->group = $request['group'];
            $teacher->position = $request['position'];
            $teacher->specialized = $request['specialized'];
            $teacher->incomingday = $request['incomingday'];

            $teacher->save();

            $record['isDone'] = 1;
            return $record;
        }
    }
}