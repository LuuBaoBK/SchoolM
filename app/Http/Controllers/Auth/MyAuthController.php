<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Redirector;
use App\Model\Sysvar;

class MyAuthController extends Controller
{
    
    public function getview(){
        
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->role == 0){
                return redirect('admin/dashboard');
            }
            elseif($user->role ==1){
                return redirect('teacher/dashboard');
            }
        }
        else
        {
            $num_student = Sysvar::find('s_next_id');
            $record['num_student'] = $num_student->value + 1;
            $num_teacher = Sysvar::find('t_next_id');
            $record['num_teacher'] = $num_teacher->value + 1;
            return view('auth.mylogin')->with('record',$record);
        }
    }
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
        elseif($user->role == 1){
            return redirect('teacher/dashboard');
        }
    }

    public function permission_denied(){
        $user = Auth::user();
        if(Auth::check())
        {
            if($user->role == 0){
                return redirect('admin/dashboard');
            }
            elseif($user->role == 1){
                return redirect('teacher/permission_denied');
            }
        }
        else
        {
            return redirect('/');
        }
    }
}
