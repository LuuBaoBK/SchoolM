<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Model\Messages;

class MailboxController extends Controller
{
    public function get_inbox(){
        // $request['data'] = "s_1;s_2;s_3;a_4!#o#!title!#o#!content"
        // $data = array();
        // $temp = array();
        // $temp['id'] = 1;
        // $temp['content'] = 'this_is_content';
        // $temp['titel'] = 'this_is_title';
        // $temp['date_time'] = 'Apr 29';
        // $temp['author'] = 'this_is_author';
        // $temp = (Object) $temp;
        // $list_mail[0] = $temp;
        // $list_mail[1] = $temp;
        $temp = Messages::all()->take(2);
        $list_mail = $temp;
        $data = $list_mail;
        // $data['inbox'] = $list_mail;
        return Response::json($data);
    }

    public function get_mail_on_login(){
        
    }
}
