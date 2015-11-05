<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Transcript;

class TranscriptController extends Controller
{
    public function index(){
        $transcriptlist = Transcript::all();
        return view('adminpage.transcript', ['transcriptlist' => $transcriptlist]);
    }

    public function store(Request $request)
    {
        $transcript = new Transcript;
        $transcript->semester = $request['semester'];
        $transcript->student_id = $request['student'];
        $transcript->subject_id = $request['subject'];
        $transcript->type = $request['type'];
        $transcript->score = $request['score'];
        $transcript->save();
        return Redirect('/admin/transcript');
    }
}
