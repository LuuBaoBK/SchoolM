<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Admin;
use Auth;
use Validator;
use Illuminate\Routing\Redirector;

class ProfileController extends Controller
{
    public function get_ad_dashboard(){
        $user = Auth::user();
        $admin = Admin::find($user->id);
        $admin->user;
        if($admin->user->dateofbirth != "0000-00-00")
        {
            $mydateofbirth = date_create_from_format("Y-m-d", $admin->user->dateofbirth);
            $mydateofbirth = date_format($mydateofbirth,"d/m/Y");
        }
        else{
            $mydateofbirth = "N/A";
        }
        $admin['mydateofbirth'] = $mydateofbirth;
    return view('adminpage.dashboard')->with('admin',$admin);
}

    public function edit_info(Request $request){
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
