<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Redirector;
use App\Model\Sysvar;
use App\Model\Student;
use App\Model\Teacher;
use App\User;

class MyAuthController extends Controller
{
    
    public function getview(){
        
        if(Auth::check())
        {
            $user = Auth::user();
            if($user->role == 0){
                return redirect('admin/dashboard');
            }
            elseif($user->role == 1){
                return redirect('teacher/dashboard');
            }
            elseif($user->role == 2){
                return redirect('student/dashboard');
            }
            elseif($user->role == 3){
                return redirect('parents/dashboard');
            }   
        }
        else
        {
            $num_student = Sysvar::find('s_next_id');
            $record['num_student'] = $num_student->value + 1;
            $num_teacher = Sysvar::find('t_next_id');
            $record['num_teacher'] = $num_teacher->value + 1;
            $year = date("Y") - 2010;
            $record['year'] = $year;
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
        elseif($user->role == 2){
            return redirect('student/dashboard');
        }
        elseif($user->role == 3){
            return redirect('parents/dashboard');
        }
    }

    public function permission_denied(){
        $user = Auth::user();
        if(Auth::check())
        {
            if($user->role == 0){
                return redirect('admin/permission_denied');
            }
            elseif($user->role == 1){
                return redirect('teacher/permission_denied');
            }
            elseif($user->role == 2){
                return redirect('student/permission_denied');
            }
            elseif($user->role == 3){
                return redirect('parents/permission_denied');
            }
        }
        else
        {
            return redirect('/');
        }
    }

    public function get_info(){
        $data = [];
        $labels = [];
        $year = date("Y");
        $month = date("m");
        $year = ($month < 8) ? $year-1 : $year;
        // $year = 2020;
        $start = $year - 7;
        if($start <= 2010){
            $start = 2010;
        }
        for($i = $start; $i <= $year ; $i++){
            $student_count = Student::where('enrolled_year','=',$i)->count();
            array_push($data, $student_count);
            array_push($labels, $i);
        }
        $record['data1'] = $data;
        $record['labels1'] = $labels;

        $student_male_count = Student::whereIn('id', 
                                                User::select('id')
                                                    ->where('gender','=','M')->get()
                                        )
                                        ->where('enrolled_year','=',$year)
                                        ->count();
        $student_female_count = Student::whereIn('id', 
                                                User::select('id')
                                                    ->where('gender','=','F')->get()
                                        )
                                        ->where('enrolled_year','=',$year)
                                        ->count();
        $record['student_male_count'] = $student_male_count;
        $record['student_female_count'] = $student_female_count;
        return $record;
    }
}
