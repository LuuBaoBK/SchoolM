<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Subject;

class AddsubjectController extends Controller
{
    public function index(){
        $subjectlist = Subject::all();
        return view('adminpage.addsubject', ['subjectlist' => $subjectlist]);
    }
    public function store(Request $request)
    {
        $subject = new Subject;
        $subject->id = $request['id'];
        $subject->subject_name = $request['name'];
        $subject->total_time = $request['totaltime'];
        $subject->save();
        return Redirect('/admin/addsubject');
    }
    public function update(Request $data)
    {
        $id = new String;
        $id=$data;
        $id->save();
        return Redirect('/admin/editsubject');
    }
}