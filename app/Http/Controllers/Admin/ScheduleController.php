<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Schedule;

class ScheduleController extends Controller
{
    public function index(){
        $schedulelist = Schedule::all();
        return view('adminpage.schedule', ['schedulelist' => $schedulelist]);
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
