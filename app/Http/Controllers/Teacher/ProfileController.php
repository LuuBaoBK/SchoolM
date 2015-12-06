<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Teacher;

class ProfileController extends Controller
{
    public function get_te_dashboard(){
    	$user = Auth::user();
        $teacher = Teacher::find($user->id);
        $teacher->user;
        if($teacher->user->dateofbirth != "0000-00-00")
        {
            $mydateofbirth = date_create_from_format("Y-m-d", $teacher->user->dateofbirth);
            $mydateofbirth = date_format($mydateofbirth,"d/m/Y");
        }
        else{
            $mydateofbirth = "N/A";
        }
        $teacher['mydateofbirth'] = $mydateofbirth;
    return view('teacherpage.dashboard')->with('teacher',$teacher);
    }	
}
