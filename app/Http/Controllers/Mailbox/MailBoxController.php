<?php

namespace App\Http\Controllers\MailBox;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Model\MsgSend;
use App\Model\MsgRecv;

class MailBoxController extends Controller
{
    public function get_mailbox(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        foreach ($user->msg_recv as $key => $value) {
            $value->content;
            $date_mess = date_create($value->content->created_at);
            $diff = date_diff($to_date,$date_mess);
            if($diff->y > 0){
                $value->content->date_diff = $diff->y." years ago";
            }
            elseif($diff->m > 0){
                $value->content->date_diff = $diff->m." months ago";
            }
            elseif($diff->d > 0){
                $value->content->date_diff = $diff->d." days ago";
            }
            elseif($diff->h > 0){
                $value->content->date_diff = $diff->h." hours ago";
            }
            elseif($diff->i > 0){
                $value->content->date_diff = $diff->i." minutes ago";
            }
            else{
                $value->content->date_diff = "1 minute ago";
            }
        }
        return view('adminpage.mailbox' , ['inbox' => $user->msg_recv]);
    }

    public function update_mailbox(Request $request){
        
    }
}
