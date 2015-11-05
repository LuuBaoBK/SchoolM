<?php

namespace App\Http\Controllers\StudentInClass;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentInClassController extends Controller
{
    //
    public function view(){

    /*	$id = '1';
    	$semester = 'hk1';
    	$classname = '1c';
    	$teacher = 'tc1';
    	//$lophoc = DB::table('lophoc')->get();
    	$data['id'] = $id;
    	$data['semester'] = $semester;
    	$data['classname'] = $classname;
    	$data['teacher']  = $teacher;
    	//$result = DB::table('lophoc')->paginate(5);*/
    	//return view("viewClass")->with('data', $data);

    	$result = DB::table('lop_hocsinh')->get();
    	
    	return view("studentinclass.view")->with('data', $result);
    }

    public function delete($id)
    {
    	$i = DB::table('lop_hocsinh')->where('id', $id)->delete();
    	if($id > 0)
    	{
    		\Session::flash('message', 'Record have been deleted successfully');
			return redirect('admin/studentclassinfo');
    	}
    }


    public function edit($class_id, $student_id)
    {
    	$row = DB::table('lop_hocsinh')->where('class_id', $class_id)->where('student_id', $class_id)->first();
    	return view("studentinclass.edit")->with('row', $row);
    }

    public function update(Request $request){
    	
    	$post = $request->all();
    	
    	$v = \Validator::make($request->all(), 
    		[
    			'class_id' => 'required',
    			'student_id' => 'required',
    			//'homeroom_teacher' => 'required',
    		]);

    	if($v->fails())
    	{
    		return redirect()->back()->withErrors($v->errors());
    	}
    	else
    	{
    		$data = array(
				'id'               => $post['id'],
				'semester'         => $post['semester'],
				'classname'        => $post['classname'],
				'homeroom_teacher' => $post['homeroom_teacher'],
    			);

    		$i = DB::table('lop_hocsinh')->where('id', $post['id'])->update($data);

    		if($i > 0)
    		{	
    			\Session::flash('message', 'Record have been updated successfully');
    			return redirect('admin/studentclassinfo');
    		}
    		//
    		return redirect('admin/studentclassinfo');
    	}
    }


    public function save(Request $request){
    	$post = $request->all();
    	$v = \Validator::make($request->all(), 
    		[
    			'class_id' => 'required',
    			'student_id' => 'required',
    		]);

    	if($v->fails())
    	{
    		return redirect()->back()->withErrors($v->errors());
    	}
    	else
    	{
    		$data = array(
				'class_id'               => $post['class_id'],
				'student_id'         => $post['student_id'],
    			);

    		$i = DB::table('lop_hocsinh')->insert($data);

    		if($i > 0)
    		{	
    			\Session::flash('message', 'Record have been saved successfully');
    			return redirect('admin/studentclassinfo');
    		}
    	}
    }
}
