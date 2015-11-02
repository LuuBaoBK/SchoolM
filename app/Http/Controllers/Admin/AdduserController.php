<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class AdduserController extends Controller
{
    public function index(){
        $userlist = User::all();
        return view('adminpage.adduser', ['userlist' => $userlist]);
    }
    public function store(Request $request)
    {
        $user = new User;
        $user->id = $request['id'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->fullname = $request['fullname'];
        $user->save();
        return Redirect('/admin/adduser');
    }
}
