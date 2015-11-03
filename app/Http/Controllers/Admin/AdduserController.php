<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Student;
use App\Model\Parents;


class AdduserController extends Controller
{
    public function get_ad(){
        $adminlist = Admin::all();
        return view('adminpage.usermange.adduser_ad', ['adminlist' => $adminlist]);
    }

    public function get_te(){
        $teacherlist = Teacher::all();
        return view('adminpage.usermange.adduser_te', ['teacherlist' => $teacherlist]);
    }

    public function store_ad(Request $request)
    {
        $user = new User;
        $admin = new Admin;
        $id = Admin::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "ad_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "0";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Admin
        $admin->id = $newid;
        $admin->ownername = $request['fullname'];
        $admin->mobilephone = $request['mobilephone'];
        $admin->save();

        return Redirect('/admin/adduser/admin');
    }

    public function store_te(Request $request)
    {
        $user = new User;
        $teacher = new Teacher;
        $id = Teacher::all()->count();
        $offset = strlen($id);
        $newid = "0000000";
        $newid = substr($newid,$offset);
        $newid = "te_".$newid.$id;

        // Create User
        $user->id = $newid;
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->address = $request['address'];
        $user->role = "1";
        $user->dateofbirth = $request['dateofbirth'];
        $user->save();

        // Create Admin
        $admin->id = $newid;
        $admin->ownername = $request['fullname'];
        $admin->mobilephone = $request['mobilephone'];
        $admin->save();

        return Redirect('/admin/adduser/teacher');
    }
}
