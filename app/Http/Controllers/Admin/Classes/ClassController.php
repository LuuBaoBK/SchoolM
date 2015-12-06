<?php

namespace App\Http\Controllers\Admin\Classes;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Classes;
use App\Model\Teacher;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use validator;

class ClassController extends Controller
{
    public function view(){
        $year = date("Y");
    	$record['classlist'] = Classes::all();
        $record['teacherlist'] = Teacher::whereNotIn('id', 
                                                        Classes::select('homeroom_teacher')->where('scholastic','=',substr($year, 2))->get()
                                                    )
                                ->get();
        foreach ($record['teacherlist'] as $key => $value) {
            $value->user;
        }
    	return view("adminpage.class.classinfo")->with('record', $record);
    }

    public function updateform(Request $request){
        $year = $request['scholastic'];
        $teacherlist = Teacher::whereNotIn('id', 
                                               Classes::select('homeroom_teacher')->where('scholastic','=',$year)->get()
                                           )
                                ->get();
        foreach ($teacherlist as $key => $value) {
            $value->user;
        }
        return $teacherlist;
    }

    public function store(Request $request){
        $rules = array(
            'class_identifier' => 'required|max:2',
            'id'   => 'isexistclasses'
        );
        $needvalidate['class_identifier'] = $request['class_identifier'];
        $needvalidate['id'] = $request['scholastic']."_".$request['grade']."_".$request['group']."_".$request['class_identifier'];
        $validator = Validator::make($needvalidate, $rules);
        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $myclass = new Classes;
            $myclass->id                  = $needvalidate['id'];
            $myclass->classname           = $request['grade'].$request['group'].$needvalidate['class_identifier'];
            $myclass->homeroom_teacher    = $request['homeroom_teacher'];
            $myclass->scholastic          = $request['scholastic'];
            $myclass->save();

            $myclass = Classes::find($needvalidate['id']);
            $record['id']               = $myclass->id;
            $record['classname']        = $myclass->classname;
            $record['scholastic']       = "20".$myclass->scholastic;

            $year = $myclass->scholastic;
            $record['teacherlist']      = Teacher::whereNotIn('id', 
                                                                Classes::select('homeroom_teacher')->where('scholastic','=',$year)->get()
                                                            )
                                        ->get();
            foreach ($record['teacherlist'] as $key => $value) {
                $value->user;
            }

            $record['homeroom_teacher'] = $myclass->teacher->user->firstname." ".$myclass->teacher->user->middlename."".$myclass->teacher->user->lastname;
            $record['isSuccess']        = 1;
            return $record;
        }
    }

    public function show(Request $request){
        if($request['scholastic'] == ""){
            $record = Classes::all();
            foreach ($record as $key => $value) {
                $value->teacher->user;
            }
        }
        else{
            $record = Classes::where('scholastic','=',$request['scholastic'])->get();
            foreach ($record as $key => $value) {
                $value->teacher->user;
            }
        }
        
        return $record;
    }

    public function get_edit_form($id){
        $class = Classes::find($id);
        $year = date("Y");
        $record['teacherlist'] = Teacher::whereNotIn('id', 
                                                        Classes::select('homeroom_teacher')->where('scholastic','=',substr($year, 2))->get()
                                                    )
                                ->get();
        foreach ($record['teacherlist'] as $key => $value) {
            $value->user;
        }

        list($scholastic, $grade, $group, $classname) = explode("_", $class->id);
        $record['scholastic']   = $scholastic;
        $record['grade']        = $grade;
        $record['group']        = $group;
        $record['classname']    = $classname;
        $record['homeroom_teacher'] = $class->teacher->id." | ".$class->teacher->user->firstname." ".$class->teacher->user->middlename." ".$class->teacher->user->lastname;
        
        return view('adminpage.class.edit_classinfo')->with("record",$record);
    }

    public function changeinfo(Request $request,$id){
        $myclass = Classes::find($id);
        list($scholastic, $grade, $group, $classname) = explode("_", $myclass->id);

        if($scholastic == $request['scholastic'] && $grade==$request['grade'] && $group==$request['group'] && $classname==$request['classname']){
            if($request['homeroomteacher'] == ""){
                //do nothing
            }
            else{
                $myclass->homeroom_teacher = $request['homeroomteacher'];
                $myclass->save();
            }
            $request->session()->flash('alert-success', 'Success Edit Class Info');
            return redirect('/admin/class/classinfo/edit/'.$id);
        }
        else{
            $rules = array(
                'classname' => 'required|max:2',
                'id'   => 'isexistclasses'
            );
            $needvalidate['classname'] = $request['classname'];
            $needvalidate['id'] = $request['scholastic']."_".$request['grade']."_".$request['group']."_".$request['classname'];
            $validator = Validator::make($needvalidate, $rules);
            if($validator->fails())
            {
               return redirect('/admin/class/classinfo/edit/'.$id)->withErrors($validator);
            }
            else
            {
                $myclass->id                  = $needvalidate['id'];
                $myclass->classname           = $request['grade'].$request['group'].$needvalidate['classname'];
                $myclass->scholastic          = $request['scholastic'];
                if($request['homeroomteacher'] == ""){
                    //do nothing
                }
                else{
                    $myclass->homeroom_teacher = $request['homeroomteacher'];
                }
                $myclass->save();
                $request->session()->flash('alert-success', 'Success Edit Class Info');
                return redirect('/admin/class/classinfo/edit/'.$needvalidate['id'])->with('message', 'Success!');
            }
        }
        
    }
}
