<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Redirector;

class MyAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        if(Auth::check())
        {
            return redirect()->intended('/dashboard');
        }
        else
        {
            $email = $request['email'];
            $password = ($request['password']);
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Authentication passed...
                return Redirect()->intended('/dashboard');
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

    public function get_dashboard(){
        $user = Auth::user();
        if($user->role == 0){
            return redirect('admin/dashboard');
        }
    }
}
