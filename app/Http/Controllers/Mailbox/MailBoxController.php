<?php

namespace App\Http\Controllers\MailBox;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Model\MsgSend;
use App\Model\MsgRecv;
use App\Model\Messages;

class MailBoxController extends Controller
{
    public function get_mailbox(){
        $msg_list = array();
        $msg_list = $this->get_inbox();
        return view('adminpage.mailbox' , ['msg_list' => $msg_list]);
    }

    public function read_msg(Request $request){
        $type = $request['type'];
        $msg_id   = $request['id'];
        $user = Auth::user();
        $id   = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);

        $msg_list = $user->msg_send()->where('id','=',$msg_id)->count();
        if($msg_list > 0){
            $msg_list = $user->msg_send()->where('id','=',$msg_id)->get();
        }
        else{
            $msg_list =     $user->msg_recv()->where('id','=',$msg_id)->get();
        }

        foreach ($msg_list as $key => $value) {
            $value->content;
            $value->content->mycontent = substr($value->content->content,0,30)."...";
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
        $record['msg_list'] = $msg_list;
        return $record;
    }

    public function update_mailbox(Request $request){
        $type = $request['type'];
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        switch($type):
            case 0: 
                $msg_list = $this->get_inbox();
            break;
            case 1:
                $msg_list = $this->get_send();
            break;
            case 2:
                $msg_list = $this->get_draft();
            break;
            case 3:
                $msg_list = $this->get_trash();
            break;
        endswitch;
        $record['msg_list'] = $msg_list;
        $record['type'] = $type;
        return $record;
    }

    public function get_inbox(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        $msg_recv_new  = $user->msg_recv()->where('isread','=','0')->where('isdelete','=','0')->orderBy('id', 'desc')->get();
        $msg_recv_read = $user->msg_recv()->where('isread','=','1')->where('isdelete','=','0')->orderBy('id', 'desc')->get();
        foreach ($msg_recv_new as $key => $value) {
            $value->class = "not_read";
            $value->content;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        foreach ($msg_recv_read as $key => $value) {
            $value->class = "read";
            $value->content;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        $msg_list['msg_recv_new'] = $msg_recv_new;
        $msg_list['msg_recv_read'] = $msg_recv_read;
        return $msg_list;
    }

    public function get_send(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        $msg_list = $user->msg_send()->where('isdelete','=','0')->where('isdraft','=','0')->orderBy('id','desc')->get();
        foreach ($msg_list as $key => $value) {
            $value->class = "not_read";
            $value->content;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        return $msg_list;
    }

    public function get_draft(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        $msg_list = $user->msg_send()->where('isdelete','=','0')->where('isdraft','=','1')->orderBy('id','desc')->get();
        foreach ($msg_list as $key => $value) {
            $value->class = "not_read";
            $value->content;
           if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        return $msg_list;
    }

    public function get_trash(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        $msg_recv_new  = $user->msg_recv()->where('isdelete','=','1')->orderBy('id', 'desc')->get();
        $msg_recv_read = $user->msg_send()->where('isdelete','=','1')->orderBy('id', 'desc')->get();
        foreach ($msg_recv_new as $key => $value) {
            $value->class = "not_read";
            $value->content;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        foreach ($msg_recv_read as $key => $value) {
            $value->class = "read";
            $value->content;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
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
        $msg_list['msg_recv_new'] = $msg_recv_new;
        $msg_list['msg_recv_read'] = $msg_recv_read;
        return $msg_list;
    }

    public function save_draft(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $type    = $request['type'];
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);
        $message = new Messages;
        $message->title = $title;
        $message->content = $content;
        $message->save();
        $msg_send = new MsgSend;
        $msg_send->id = $message->id;
        $msg_send->sendby = $user->id;
        $msg_send->isdraft = 1;
        $msg_send->isdelete = 0;
        $msg_send->save();
        $record = $type;
        return $record;
    }

    public function send_mail(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $to_list = $request['to_list'];
        $type    = $request['type'];
        
        $record['0'] = $type;
        $record['1'] = $title;
        $record['2'] = $to_list;
        $record['3'] = $content;
        return $record;
    }
    
}
