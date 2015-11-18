<?php

namespace App\Http\Controllers\Classes;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassController extends Controller
{
    public function view(){
    	$result = DB::table('classes')->get(); 	
    	return view("adminpage.class.view")->with('data', $result);
    }

    public function form(){
    	return view('class.form');
    }

    public function delete($id)
    {
    	$i = DB::table('lophoc')->where('id', $id)->delete();
    	if($id > 0)
    	{
    		\Session::flash('message', 'Record have been deleted successfully');
			return redirect('admin/classinfo');
    	}
    }


    public function edit($id)
    {
    	$row = DB::table('lophoc')->where('id', $id)->first();
    	return view("class.edit")->with('row', $row);
    }

    public function update(Request $request){
    	
    	$post = $request->all();
    	
    	$v = \Validator::make($request->all(), 
    		[
    			'id' => 'required',
    			'semester' => 'required',
    			'classname' => 'required',
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

    		$i = DB::table('lophoc')->where('id', $post['id'])->update($data);

    		if($i > 0)
    		{	
    			\Session::flash('message', 'Record have been updated successfully');
    			return redirect('admin/classinfo');
    		}
    		//
    		return redirect('admin/classinfo');
    	}
    }


    public function save(Request $request){
    	$post = $request->all();
    	$v = \Validator::make($request->all(), 
    		[
    			'id' => 'required',
    			'semester' => 'required',
    			'classname' => 'required',
    			'homeroom_teacher' => 'required',
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

    		$i = DB::table('lophoc')->insert($data);

    		if($i > 0)
    		{	
    			\Session::flash('message', 'Record have been saved successfully');
    			return redirect('admin/classinfo');
    		}
    	}
    }
}
