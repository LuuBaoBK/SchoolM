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


class ParentManageController extends Controller
{
    public function get_pa(){
        //$parentlist = Parents::orderBy('id', 'desc')->get();
        $parent = array(
            'id' => '',
            'email' => '',
            'firstname' => '',
            'middlename' => '',
            'lastname' => '',
            'mobilephone' => '',
            'homephone' => '',
            'dateofbirth' => '',
            'address' => '',
            'studentlist' => array()
            );
        return view('adminpage.usermanage.adduser_pa')->with('parent' ,$parent);
    }

    public function get_pa_from_child($id){
        $parent = Parents::find($id);
        foreach($parent->student as $child){
            $child->user;
        }
        $parent = array(
            'id' => $parent->id,
            'email' => $parent->user->email,
            'firstname' => $parent->user->firstname,
            'middlename' => $parent->user->middlename,
            'lastname' => $parent->user->lastname,
            'mobilephone' => $parent->mobilephone,
            'homephone' => $parent->homephone,
            'dateofbirth' => $parent->user->dateofbirth,
            'address' => $parent->user->address,
            'studentlist' => $parent->student
            );
        return view('adminpage.usermanage.adduser_pa')->with('parent' ,$parent);
    }

    public function show(Request $request){  
        $filter_fullname_parent = $request['filter_fullname_parent'];
        $filter_fullname_student = $request['filter_fullname_student'];
        $filter_enrolled_year = $request['filter_enrolled_year'];
        if($filter_enrolled_year == 0){
            $parent_id_list = Parents::select('id')
                                 ->whereIn( 'id', 
                                        Student::select('parent_id')
                                        ->whereIn('id',
                                                User::select('id')
                                                    ->where('fullname','LIKE','%'.$filter_fullname_student.'%')
                                                    ->get()
                                            )
                                        ->get()
                                        )
                                ->get();
        }
        else{
            $parent_id_list = Parents::select('id')
                                 ->whereIn( 'id', 
                                        Student::select('parent_id')
                                        ->whereIn('id',
                                                User::select('id')
                                                    ->where('fullname','LIKE','%'.$filter_fullname_student.'%')
                                                    ->get()
                                            )
                                        ->where('enrolled_year', "=", $filter_enrolled_year)
                                        ->get()
                                        )
                                ->get();
        }
        $parentlist =   User::whereIn('id',$parent_id_list)
                            ->orderBy('id','asc')
                            ->get();
        $record['mydata'] = $parentlist;
        return $record;
    }

    public function getdata(Request $request){
        $parent = Parents::find($request['id']);
        $parent->user;
        $parent->student;
        foreach ($parent->student as $row) {
            $row->user;}
        return $parent;
    }

    public function editdata(Request $request){
        if($request['id'] == ""){
            $record['isSuccess'] = 0;
            return $record;
        }

        $rules = array(
            'firstname'   => 'max:20',
            'middlename'  => 'max:20',
            'lastname'    => 'max:20',
            'mobilephone' => 'digits_between:10,11',
            'homephone'   => 'digits_between:10,11',
            'dateofbirth' => 'date_format:d/m/Y',
            'address'     => 'max:120'      
        );

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {  
            $record = $validator->messages();
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

            $parent = Parents::find($request['id']);
            $parent->user->firstname      = $request['firstname'];
            $parent->user->middlename     = $request['middlename'];
            $parent->user->lastname       = $request['lastname'];
            $parent->user->fullname       = $request['firstname']." ".$request['middlename']." ".$request['lastname'];
            $parent->mobilephone          = $request['mobilephone'];
            $parent->homephone            = $request['homephone'];
            $parent->user->address        = $request['address'];
            $parent->user->dateofbirth    = $dateofbirth;
            $parent->save();
            $parent->user->save();
            $record['isSuccess'] = 1;
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
            $user->fullname = $request['firstname']." ".$request['middlename']." ".$request['lastname'];
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

    public function reset_password($id){
        $parent = Parents::find($id);
        $parent->user;
        $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $parent->user->password = bcrypt($password);
        $parent->user->save();
        if($parent->user->dateofbirth == "0000-00-00"){
            $dateofbirth = "";
        }
        else
        {
            $dateofbirth = date_create($parent->user->dateofbirth);
            $dateofbirth = date_format($dateofbirth, "d/m/Y");
        }
        return view('adminpage.usermanage.print_pa', ['parent' => $parent, 'password' => $password, 'dateofbirth' => $dateofbirth]);
    }
}
