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
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Parents;
use App\Model\Student;
use App\Model\StudentClass;
use App;

class MailBoxController extends Controller
{
    public function get_mailbox(){
        $msg_list = array();
        $msg_list = $this->get_inbox();
        $user = Auth::user();
        $id   = $user->id;
        $prefix = substr($id,0,1);
        $role = $user->role;
        if($prefix == "a"){
            return view('adminpage.mailbox' , ['msg_list' => $msg_list, 'my_id' => $id, 'role' => $role]);
        }
        else if($prefix == "t"){
            return view('teacherpage.mailbox' , ['msg_list' => $msg_list, 'my_id' => $id, 'role' => $role]);
        }
        else if($prefix == "s"){
            return view('studentpage.mailbox', ['msg_list' => $msg_list, 'my_id' => $id, 'role' => $role]);
        }
        else if($prefix == "p"){
            return view('parentpage.mailbox', ['msg_list' => $msg_list, 'my_id' => $id, 'role' => $role]);
        }
        
    }

    public function read_msg(Request $request){
        $type = $request['type'];
        $msg_id   = $request['id'];
        $user = Auth::user();
        $id   = $user->id;
        $user = User::find($id);
        $count_msg = 0;

        $count_msg = $user->msg_send()->where('id','=',$msg_id)->count();
        if($count_msg > 0){
            $msg_list = $user->msg_send()->where('id','=',$msg_id)->get();
        }
        else{
            $msg_list =     $user->msg_recv()->where('id','=',$msg_id)->get();
        }

        foreach ($msg_list as $key => $value) {
            if($count_msg == 0){
                $value->isread = "1";
                $value->save();
                $value->send_by->author;
                $value->author_name = $value->send_by->author->firstname." ".$value->send_by->author->middlename." ".$value->send_by->author->lastname;
                $value->author_id = $value->send_by->author->id;
            }
            else{
                $value->author;
                $value->author_name = $value->author->firstname." ".$value->author->middlename." ".$value->author->lastname;
                $value->author_id = $value->author->id;
            }
            $value->content;
            $value->content->mycontent = substr($value->content->content,0,30)."...";
            $value->content->date_diff = $this->date_diff($value->content->created_at);
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
        $msg_recv_new  = $user->msg_recv()->where('isread','=','0')->where('isdelete','=','0')->orderBy('id', 'desc')->get();
        $msg_recv_new_count  = $user->msg_recv()->where('isread','=','0')->where('isdelete','=','0')->get()->count();
        $msg_recv_read = $user->msg_recv()->where('isread','=','1')->where('isdelete','=','0')->orderBy('id', 'desc')->get();
        foreach ($msg_recv_new as $key => $value) {
            $value->class = "not_read";
            $value->content;
            $value->send_by->author;
            $value->author_name = $value->send_by->author->firstname." ".$value->send_by->author->middlename." ".$value->send_by->author->lastname;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
            $value->content->date_diff = $this->date_diff($value->content->created_at);
        }
        foreach ($msg_recv_read as $key => $value) {
            $value->class = "read";
            $value->content;
            $value->send_by->author;
            $value->author_name = $value->send_by->author->firstname." ".$value->send_by->author->middlename." ".$value->send_by->author->lastname;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
            $value->content->date_diff = $this->date_diff($value->content->created_at);
        }
        $msg_list['msg_recv_new'] = $msg_recv_new;
        $msg_list['msg_recv_read'] = $msg_recv_read;
        $msg_list['msg_recv_new_count'] = $msg_recv_new_count;
        return $msg_list;
    }

    public function get_send(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $msg_list = $user->msg_send()->where('isdelete','=','0')->where('isdraft','=','0')->orderBy('id','desc')->get();
        foreach ($msg_list as $key => $value) {
            $value->class = "not_read";
            $value->content;
            $value->author;
            $value->author_name = $value->author->firstname." ".$value->author->middlename." ".$value->author->lastname;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
            $value->content->date_diff = $this->date_diff($value->content->created_at);
        }
        return $msg_list;
    }

    public function get_draft(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        $msg_list = $user->msg_send()->where('isdelete','=','0')->where('isdraft','=','1')->orderBy('id','desc')->get();
        foreach ($msg_list as $key => $value) {
            $value->class = "not_read";
            $value->content;
            $value->author;
            $value->author_name = $value->author->firstname." ".$value->author->middlename." ".$value->author->lastname;
           if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
            $value->content->date_diff = $this->date_diff($value->content->created_at);
        }
        return $msg_list;
    }

    public function get_trash(){
        $user = Auth::user();
        $id = $user->id;
        $user = User::find($id);
        //msg_recv_new is recv list
        $msg_recv_new  = $user->msg_recv()->where('isdelete','=','1')->orderBy('id', 'desc')->get();
        //msg_recv_read is send list
        $msg_recv_read = $user->msg_send()->where('isdelete','=','1')->orderBy('id', 'desc')->get();
        foreach ($msg_recv_new as $key => $value) {
            $value->class = "not_read";
            $value->content;
            $value->send_by->author;
            $value->author_name = $value->send_by->author->firstname." ".$value->send_by->author->middlename." ".$value->send_by->author->lastname;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }
            $value->content->date_diff = $this->date_diff($value->content->created_at);
        }
        foreach ($msg_recv_read as $key => $value) {
            $value->class = "read";
            $value->content;
            $value->author;
            $value->author_name = $value->author->firstname." ".$value->author->middlename." ".$value->author->lastname;
            if($value->content->content == ""){
                $value->content->mycontent = "N/A";
            }
            else{
                $value->content->mycontent = substr($value->content->content,0,30)."...";
            }

            $value->content->date_diff = $this->date_diff($value->content->created_at);
            
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
        $message = new Messages;
        $message->title = $title;
        $message->content = $content;
        $message->created_at = $date;
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

    public function my_send_mail(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $to_list = $request['to_list'];
        $type    = $request['type'];

        $success_list = array();
        $not_found_list = array();
        $wrong_format_list = [];
        $temp_list = array();

        if($to_list == ""){
            $record[0] = "wrong format";
            return $record;
        }
        else{
            $item_list = explode(" ", $to_list);
            foreach ($item_list as $key => $item) {
                if($item == ""){
                    continue;
                }
                else{
                    if(strpos($item,'@') !== false){
                        $email = explode("@", $item);
                        if($email[1] == "schoolm.com"){
                            array_push($not_found_list, $email[0]);
                        }
                        else{
                            array_push($wrong_format_list, $item);
                        }
                    }
                    else if(strpos($item,'group=') !== false){
                        if(Auth::user()->role <= 1)
                        {
                            $group = explode("group=", $item);
                            switch ($group[1]) {
                                case 'admin':
                                    $temp_list = Admin::select('id')->get();
                                    break;
                                case 'teacher':
                                    $temp_list = Teacher::select('id')->get();
                                    break;
                                case 'parent':
                                    $temp_list = Parents::select('id')->get();
                                    break;
                                case 'student':
                                    $temp_list = Student::select('id')->get();
                                    break;                            
                                case '':
                                    $temp_list = [];
                                    break;
                                default:
                                    $temp_list = StudentClass::select('student_id as id')->where('class_id','like',$group[1].'%')->get();
                                    break;
                            }
                            if(count($temp_list) == 0){
                                array_push($wrong_format_list, $item." 0 Mail sent");
                            }
                            else{
                                foreach ($temp_list as $key => $value) {
                                    array_push($not_found_list, $value->id);
                                }
                            }
                        }
                        else{
                            array_push($wrong_format_list, $item." Permission denied");
                        }
                    }
                    else{
                        array_push($wrong_format_list, $item);
                    }
                }
            }
            $not_found_list = array_unique($not_found_list);
            $success_list = User::whereIn('id',$not_found_list)->where('id','<>',Auth::user()->id)->get();
            $temp_list = array();
            foreach ($success_list as $key => $value) {
                array_push($temp_list, $value->id);
            }
            $not_found_list = array_merge(array_diff($not_found_list, $temp_list));
            $mycount = count($success_list);
            if($mycount > 0){
                $date = date('Y-m-d H:i:s');
                $message = new Messages;
                $message->content = $content;
                $message->title = $title;
                $message->created_at = $date;
                $message->save();
                foreach ($success_list as $key => $value) {
                    $msg_recv = new MsgRecv;
                    $msg_recv->recvby = $value->id;
                    $msg_recv->isdelete = 0;
                    $msg_recv->isread = 0;
                    $msg_recv->id = $message->id;
                    $msg_recv->save();
                }
                $user = Auth::user();
                $msg_send = new MsgSend;
                $msg_send->id = $message->id;
                $msg_send->sendby = $user->id;
                $msg_send->isdelete = 0;
                $msg_send->isdraft = 0;  
                $msg_send->save();
                $record[0] = "send";

                foreach($temp_list as $key => $value){
                    $temp_list[$key] = $value."-channel";
                }
                $pusher = App::make('pusher');
                $pusher->trigger( $temp_list,
                              'new_mail_event', 
                              $user->id."-".$user->fullname);
                }
                else{
                    $record[0] = "not_send";
            }
            $record[1] = $success_list;
            $record[2] = $not_found_list;
            $record[3] = $wrong_format_list;

            return $record;
        }
        
    }
    // public function send_mail(Request $request){
    //     $content = $request['content'];
    //     $title   = $request['title'];
    //     $to_list = $request['to_list'];
    //     $type    = $request['type'];

    //     if(strpos($to_list,'@') == false && strpos($to_list,'group=') == false){
    //         $record[0] = "wrong format";
    //         return $record;
    //     }

    //     $success_list = array();
    //     $not_found_list = array();
    //     $wrong_format_list = [];
    //     $temp_list = array();
    //     $email_list = explode(" ", $to_list);

    //     foreach ($email_list as $key => $value) {
    //         $is_email = strpos($value,'@');
    //         if($is_email == true ){
    //             $email = explode("@", $value);
    //             if($email[1] == "schoolm.com"){
    //                 array_push($not_found_list, $email[0]);
    //             }
    //             else{
    //                 array_push($wrong_format_list, $value);
    //             }
    //         }
    //         else{
    //             if($value != ""){
    //                 if(strpos($value, 'group=')){
    //                     $group = explode("group=", $value);
    //                     switch ($group[1]) {
    //                         case 'admin':
    //                             $import_list = Admin::select('id')->get();
    //                             break;
    //                         case 'teacher':
    //                             $import_list = Teacher::select('id')->get();
    //                             break;
    //                         case 'parent':
    //                             $import_list = Parents::select('id')->get();
    //                             break;
    //                         case 'student':
    //                             $import_list = Student::select('id')->get();
    //                             break;
    //                         default:
    //                             array_push($wrong_format_list, $value);
    //                             break;
    //                     }
    //                     foreach ($import_list as $key => $value) {
    //                         return $value;
    //                     }
    //                 }
    //                 else{
    //                     array_push($wrong_format_list,$value);
    //                 }
    //             }
    //         }
    //     }

    //     $success_list = User::whereIn('id',$not_found_list)->where('id','<>',Auth::user()->id)->get();
    //     foreach ($success_list as $key => $value) {
    //         array_push($temp_list, $value->id);
    //     }

    //     $not_found_list = array_merge(array_diff($not_found_list, $temp_list));

    //     $mycount = count($success_list);
    //     if($mycount > 0){
    //         $date = date('Y-m-d H:i:s');
    //         $message = new Messages;
    //         $message->content = $content;
    //         $message->title = $title;
    //         $message->created_at = $date;
    //         $message->save();
    //         foreach ($success_list as $key => $value) {
    //             $msg_recv = new MsgRecv;
    //             $msg_recv->recvby = $value->id;
    //             $msg_recv->isdelete = 0;
    //             $msg_recv->isread = 0;
    //             $msg_recv->id = $message->id;
    //             $msg_recv->save();
    //         }
    //         $user = Auth::user();
    //         $msg_send = new MsgSend;
    //         $msg_send->id = $message->id;
    //         $msg_send->sendby = $user->id;
    //         $msg_send->isdelete = 0;
    //         $msg_send->isdraft = 0;  
    //         $msg_send->save();
    //         $record[0] = "send";

    //         foreach($temp_list as $key => $value){
    //             $temp_list[$key] = $value."-channel";
    //         }
    //         $pusher = App::make('pusher');
    //         $pusher->trigger( $temp_list,
    //                       'new_mail_event', 
    //                       $temp_list);
    //         }
    //         else{
    //             $record[0] = "not_send";
    //     }

    //     $record[1] = $success_list;
    //     $record[2] = $not_found_list;
    //     $record[3] = $wrong_format_list;

    //     return $record;
    // }

    public function delete_mail(Request $request){
        $type = $request['type'];
        $id = $request['id'];
        $user_id = Auth::user()->id;
        if($type == 0){
            $msg = MsgRecv::where('id','=',$id)->where('recvby','=',$user_id)->first();
            $msg->isdelete = 1;
            $msg->save();
            if($msg->isread == 0){
                return "done";
            }
        }
        else if($type == 1 || $type == 2){
            MsgSend::where('id','=',$id)->where('sendby','=',$user_id)->update(['isdelete' => 1]);
        }
        return "done";
    }

    public function date_diff($msg_date){
        $date = date('Y-m-d H:i:s');
        $to_date = date_create($date);

        $date_mess = date_create($msg_date);
        $diff = date_diff($to_date,$date_mess);
        if($diff->y > 0){
            $record = $diff->y." years ago";
        }
        elseif($diff->m > 0){
            $record = $diff->m." months ago";
        }
        elseif($diff->d > 0){
            $record = $diff->d." days ago";
        }
        elseif($diff->h > 0){
            $record = $diff->h." hours ago";
        }
        elseif($diff->i > 0){
            $record = $diff->i." minutes ago";
        }
        else{
            $record = "1 minute ago";
        }
        return $record;
    }
    
}
