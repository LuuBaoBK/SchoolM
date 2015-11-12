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


class AdminManageController extends Controller
{
    public function get_ad(){
        $adminlist = Admin::all();
        return view('adminpage.usermanage.adduser_ad', ['adminlist' => $adminlist]);
    }

    public function store_ad(Request $request)
    {
        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'mobilephone'   => 'digits_between:10,11',
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
            $user = new User;
            $admin = new Admin;
            //Create ID
            $ad_next_id = Sysvar::find('a_next_id');
            $ad_next_id->value = $ad_next_id->value + 1;
            $id = $ad_next_id->value;
            $offset = strlen($id);
            $newid = "0000000";
            $newid = substr($newid,$offset);
            $newid = "a_".$newid.$id;
            //Handle Date Format
            if($request['dateofbirth'] != "")
            {
                $dateofbirth = date_create_from_format("d/m/Y", $request['dateofbirth']);
                $dateofbirth = date_format($dateofbirth,"Y-m-d");
            }
            else{
                $dateofbirth = $request['dateofbirth'];
            }

            //Create Email & Password
            $email = $newid."@schoolm.com";
            $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

            // Create User
            $user->id = $newid;
            $user->email = $email;
            $user->password = $password;
            $user->firstname = $request['firstname'];
            $user->middlename = $request['middlename'];
            $user->lastname = $request['lastname'];
            $user->address = $request['address'];
            $user->role = "0";
            $user->dateofbirth = $dateofbirth;
            $user->save();

            $admin->id = $newid;
            $admin->mobilephone = $request['mobilephone'];
            $admin->create_by = $request->user()->id;
            $admin->save();
            
            $ad_next_id->save();

            $record = array
            (
                "id" => $newid,
                "fullname" => $request['firstname']." ".$request['middlename']." ".$request['lastname'],
                "email" => $email,
                "mobilephone" => $admin->mobilephone,
                "dateofbirth" => $request['dateofbirth'],
                "role" => $user->role,
                "create_by" => $admin->create_by,
                "address" => $request['address'],
                "button" => "<i class = 'fa fa-fw fa-edit'></i>
                            <a href='/admin/manage-user/admin/edit/$newid' >Edit</a>",
                "isDone" => 1 
            );  
            return $record;
        }
    }

    public function get_edit_form($id)
    {
        $admin = Admin::find($id);
        if($admin->user->dateofbirth == "0000-00-00"){
            $dateofbirth = "";
        }
        else
        {
            $dateofbirth = date_create($admin->user->dateofbirth);
            $dateofbirth = date_format($dateofbirth, "d/m/Y");
        }
            
        $admin['mydateofbirth'] = $dateofbirth;
        return view('adminpage.usermanage.edit_ad')->with('admin',$admin);
    }

    public function edit_ad(Request $request){
        $id = $request['id'];
        $user  = User::find($id);
        $admin = Admin::find($id);

        $rules = array(
            'firstname'     => 'max:20',
            'middlename'    => 'max:20',
            'lastname'      => 'max:20',
            'mobilephone'   => 'digits_between:10,11',
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

            $record['dateofbirth'] = $dateofbirth;
            
            $user->firstname   = $request['firstname'];
            $user->middlename  = $request['middlename'];
            $user->lastname    = $request['lastname'];
            $user->dateofbirth = $dateofbirth;
            $user->address     = $request['address'];
            $user->save();

            $admin->mobilephone = $request['mobilephone'];
            $admin->save();

            $record['isDone'] = 1;
            return $record;
        }
    }
}
