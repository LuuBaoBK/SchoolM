<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Subject;

class EditsubjectController extends Controller
{
    public function edit($id)
    {
    	$row = Subject::where('id', $id)->first();
    	return view("adminpage.editsubject", ['row' => $row]);
    }

    public function update(Request $request)
    {	
    	$data = Subject::where('id', $request['id'])->first();
    	$data->id = $request['id'];
    	$data->subject_name = $request['name'];
    	$data->total_time = $request['totaltime'];
    	$data->update();
    	return Redirect('admin/addsubject');
    }

    public function delete($id)
    {
        $i = Subject::where('id', $id)->delete();
        return redirect('admin/addsubject');
    }
}