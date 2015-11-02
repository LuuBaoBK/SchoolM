<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Subject;

class EditsubjectController extends Controller
{
    public function edit(Request $request)
    {
        $subject = new Subject;
        $subject->id = $request['id'];
        $subject->subject_name = $request['name'];
        $subject->total_time = $request['totaltime'];
        $subject->save();
        return view('adminpage.editsubject');
    }
}