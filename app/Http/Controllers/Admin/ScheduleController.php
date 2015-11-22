<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Schedule;
use App\Model\Subject;
use App\Model\Classes;

class ScheduleController extends Controller
{
    public function index(){
        return view('adminpage.schedule');
    }

    public function getschedule(Request $request)
    {
        $tkb = array();
        $id = $request['classname'];
        for ($i=1;$i<=5;$i++)
        {
            $day = Schedule::where('class_id', $id)->where('day', $i)->orderBy('start_at', 'asc')->get();
            foreach ($day as $key) {
                 for ($z=$key->start_at;$z<$key->start_at + $key->duration;$z++)
                 {
                    $name = Subject::select('subject_name')->where('id', $key->subject_id)->first();
                    $tkb[$z][$i] = $name->subject_name;
                 }
            }
        }

        $record = array(
                'isSuccess' => 1,
                'mydata' => $tkb
            );
        return $record;
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
