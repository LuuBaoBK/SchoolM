<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


class MyAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        if(Auth::check())
        {
            return redirect()->intended('admin/dashboard');
        }
        else
        {
            $email = $request['email'];
            $password = ($request['password']);
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Authentication passed...
                return Redirect()->intended('admin/dashboard');
            }
            else{
                $request->session()->flash('alert-warning', 'Incorrect Email Or Password!');
                return Redirect('/');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect('/');

    }
}
