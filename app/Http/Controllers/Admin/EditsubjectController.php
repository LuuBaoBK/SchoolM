<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use validator;
use App\Model\Subject;
use App\Model\Scoretype;

class EditsubjectController extends Controller
{
    public function get_view($id)
    {
    	$subject = Subject::where('id', $id)->first();
        $score_type = $subject->score_type;
        $record['subject'] = $subject;
        $record['score_type'] = $score_type;
        //dd($record['score_type']);
    	return view("adminpage.subjectmanage.editsubject", ['record' => $record]);
    }

    public function update(Request $request)
    {	
        $rules = array(
            'subject_name'     => 'required|max:40',
            'total_time'    => 'digits_between:1,3',
        );
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
        	$data = Subject::where('id', $request['id'])->first();
        	$data->subject_name = $request['subject_name'];
        	$data->total_time = $request['total_time'];
        	$data->update();
            $record['isDone'] = 1;
        	return $record;
        }
    }

    public function add_type(Request $request){
        $rules = array(
            'score_type' =>     'required|max:40',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        else
        {
            $data = new Scoretype;
            $data->subject_id = $request['subject_id'];
            $data->factor = $request['factor'];
            $data->type = $request['score_type'];
            $data->month = $request['month'];
            $data->applyfrom = $request['applyfrom'];
            $data->disablefrom = 3000;
            $data->save();
            $record['isDone'] = 1;
            $record['data'] = $data;
            return $record;
        }
    }

    public function edit_type(Request $request){
        $rules = array(
            'score_type' =>     'required|max:40',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
           $record =  $validator->messages();
           return $record;
        }
        elseif($request['score_type'] == $request['old_score_type'])
        {
            $data = Scoretype::where('id','=',$request['scoretype_id'])
                             ->update(['factor' => $request['factor'], 'month' => $request['month']]);
            $record['isDone'] = 1;
            $record['data'] = $data;
            return $record;
        }
        else
        {
            $data = Scoretype::where('id','=',$request['scoretype_id'])
                         ->update(['factor'=> $request['factor'], 'type' => $request['score_type'], 'month' => $request['month']]);
            $record['isDone'] = 1;
            $record['data'] = $data;
            return $record;
        }
    }

    public function disable_scoretype(Request $request){
        $year = date("Y");
        $month = date("m");
        if($month < 8){
            $year = $year - 1;
        }
        $year = substr($year, 2,2);

        $data = Scoretype::where('id','=',$request['scoretype_id'])
                     ->update(['disablefrom' => $year]);
        $record['year'] = $year;
        return $record;
    }
}