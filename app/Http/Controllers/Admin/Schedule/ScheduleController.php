<?php

namespace App\Http\Controllers\Admin\Schedule;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function main_menu_view(){
        return view('adminpage.schedule.main_menu');
    }
}
