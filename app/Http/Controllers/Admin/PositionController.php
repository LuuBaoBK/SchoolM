<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
   public function get_view(){
    return view('adminpage.position');
   }
}
