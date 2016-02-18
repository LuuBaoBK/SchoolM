<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Position;
use App\Model\Teacher;
use App\User;
class PositionController extends Controller
{
   public function get_view(){
   		$position = Position::all();
   		foreach ($position as $key => $value) {
	        $value->members;
	        $value->total = count($value->members);
	    }
    	return view('adminpage.position')->with('position',$position);
   }

   public function change_name(Request $request){
   		$position = Position::find($request['id'] + 1);
   		$position->position_name = $request['name'];
   		$position->save();
   		$record = $request['name'];
   		return $record;
   }
}
