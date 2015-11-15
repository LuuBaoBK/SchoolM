<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Schedule;

class ScheduleController extends Controller
{
    public function index(){
        $tiet1 = Schedule::where("class_id", 1)->where("start_at", 1)->orderBy("day", 'asc')->get();
        $tiet = array($tiet1);
        for ($i=2;$i<=10;$i++)
        {
            $temp = Schedule::where("class_id", 1)->where("start_at", 2)
                                                  ->orwhere(function ($query)
                                                  {
                                                    $query->where("start_at", 1)
                                                    ->where("duration", 2);
                                                  })
                                                  ->orderBy("day", 'asc')
                                                  ->get();
            array_push($tiet, $temp);
        }
        return view('adminpage.schedule', ['schedulelist' => $tiet]);
    }

    public function store(Request $request)
    {
        $Schedule = new Schedule;
        $Schedule->class_id = $request['class'];
        $Schedule->subject_id = $request['subject'];
        $Schedule->day = $request['day'];
        $Schedule->start_at = $request['start'];
        $Schedule->duration = $request['duration'];
        $Schedule->save();
        return Redirect('/admin/schedule');
    }
}
