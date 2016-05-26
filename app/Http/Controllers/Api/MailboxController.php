<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Model\Messages;
use App\Model\MsgRecv;
use App\Model\MsgSend;
use Auth;
use App\User;
use App\Model\Admin;
use App\Model\Teacher;
use App\Model\Parents;
use App\Model\Student;
use App\Model\StudentClass;
use App; 

class MailboxController extends Controller
{
    public function get_inbox(Request $request){
        //prepare data
        $user = Auth::user();
        $offset = $request['length'];
        $count_full_content = 0;
        //return data
        $return_data = array();
        $return_data['list_inbox'] = array();
        //excute
        $inbox_list = MsgRecv::where('recvby','=',$user->id)->where('isdelete','=',0)->orderBy('id','desc')->take($offset)->get();
        foreach ($inbox_list as $key => $value) {
            $temp = array();
            $temp['id'] = $value->id;
            $temp['title'] = ($value->content->title == "") ? "No Title" : $value->content->title;
            if($count_full_content < 5)
                $temp['content'] = ($value->content->content == "" ) ? "N/A" : $value->content->content;
            else
                $temp['content'] = $value->content->mycontent = substr(strip_tags ($value->content->content),0,50);
            $temp_date = date_create($value->content->create_at);
            $temp['date_time'] = date_format($temp_date,"M d");
            $temp['author'] = $value->send_by->author->id."@schoolm.com";
            $temp['isRead'] = ($value->isread == 0)? "true" : "false";
            $temp['receiver'] = $user->id."@schoolm.com";
            array_push($return_data['list_inbox'], $temp);
            $count_full_content += 1 ;
        }
        $return_data['new_mail'] = MsgRecv::where('recvby','=',$user->id)->where('isread','=',0)->where('isdelete','=',0)->get()->count();
        return $return_data;
    }

    public function get_sent(Request $request){
        //prepare data
        $user = Auth::user();
        $offset = $request['length'];
        $count_full_content = 0;
        //return data
        $return_data = array();
        $return_data['list_inbox'] = array();
        //excute
        $sent_list = MsgSend::where('sendby','=',$user->id)->where('isdelete','=',0)->where('isdraft','=',0)->orderBy('id','desc')->take($offset)->get();
        foreach ($sent_list as $key => $value) {
            $temp = array();
            $temp['id'] = $value->id;
            $temp['title'] = ($value->content->title == "") ? "No Title" : $value->content->title;
            if($count_full_content < 5)
                $temp['content'] = ($value->content->content == "" ) ? "N/A" : $value->content->content;
            else
                $temp['content'] = $value->content->mycontent = substr(strip_tags($value->content->content),0,50);
            $temp_date = date_create($value->content->create_at);
            $temp['date_time'] = date_format($temp_date,"M d");
            $temp['author'] = $user->id."@schoolm.com";
            foreach ($value->recv_by as $key => $receiver) {
                if($key == 0)
                    $temp['receiver'] = $receiver->recvby."@schoolm.com";
                else
                    $temp['receiver'] .= " ".$receiver->recvby."@schoolm.com";
            }
            array_push($return_data['list_inbox'], $temp);
            $count_full_content += 1 ;
        }
        return $return_data;
    }

    public function get_draft(Request $request){
        //prepare data
        $user = Auth::user();
        $offset = $request['length'];
        //return data
        $return_data = array();
        $return_data['list_inbox'] = array();
        //excute
        $sent_list = MsgSend::where('sendby','=',$user->id)->where('isdelete','=',0)->where('isdraft','=',1)->orderBy('id','desc')->take($offset)->get();
        foreach ($sent_list as $key => $value) {
            $temp = array();
            $temp['id'] = $value->id;
            $temp['title'] = ($value->content->title == "") ? "No Title" : $value->content->title;
            $temp['content'] = ($value->content->content == "" ) ? "N/A" : $value->content->content;
            $temp_date = date_create($value->content->create_at);
            $temp['date_time'] = date_format($temp_date,"M d");
            $temp['author'] = $user->id."@schoolm.com";
            array_push($return_data['list_inbox'], $temp);
        }
        return $return_data;
    }

    public function get_trash(Request $request){
        //prepare data
        $user = Auth::user();
        $offset = $request['length'];
        //return data
        $return_data = array();
        $return_data['list_inbox'] = array();
        //excute
        $sent_list = MsgSend::select('id')->where('sendby','=',$user->id)->where('isdelete','=',1)->get();
        $read_list = MsgRecv::select('id')->where('recvby','=',$user->id)->where('isdelete','=',1)->get();
        $id_list = array();
        foreach ($sent_list as $key => $value) {
            array_push($id_list, $value->id);
        }
        foreach ($read_list as $key => $value) {
            array_push($id_list, $value->id);
        }
        $mail_list = Messages::whereIn('id',$id_list)->orderBy('id','desc')->take($offset)->get();
        foreach ($mail_list as $key => $value) {
            $temp = array();       
            $temp['id'] = $value->id;
            $temp['title'] = ($value->title == "") ? "No Title" : $value->title;
            $temp['content'] = ($value->content == "") ? "N/A" : substr(strip_tags($value->content), 0,50);
            $temp_date = date_create($value->create_at);
            $temp['date_time'] = date_format($temp_date,"M d");
            $temp['author'] = $user->id."@schoolm.com";
            $temp_recv_list = MsgRecv::where('id','=',$value->id)->get();
            $temp['receiver'] = "";
            foreach ($temp_recv_list as $key => $receiver) {
                if($key == 0)
                    $temp['receiver'] = $receiver->recvby."@schoolm.com";
                else
                    $temp['receiver'] .= " ".$receiver->recvby."@schoolm.com";
            }
            array_push($return_data['list_inbox'], $temp);
        }
        return $return_data;
    }

    public function read_mail(Request $request){
        $user = Auth::user();
        $mail_id = $request['mail_id'];
        $mail = Messages::find($mail_id);
        $temp = array();
        $temp['id'] = $mail->id;
        $temp['title'] = ($mail->title == "") ? "No Title" : $mail->title;
        $temp['content'] = ($mail->content == "") ? "N/A" : $mail->content;
        $temp_date = date_create($mail->create_at);
        $temp['date_time'] = date_format($temp_date,"M d");
        $temp['author'] = $mail->send_by->sendby."@schoolm.com";
        $temp_recv_list = MsgRecv::where('id','=',$mail->id)->get();
        $temp['receiver'] = "";
        foreach ($temp_recv_list as $key => $receiver) {
            if($key == 0)
                $temp['receiver'] = $receiver->recvby."@schoolm.com";
            else
                $temp['receiver'] .= " ".$receiver->recvby."@schoolm.com";
        }
        //update status đã đọc
        MsgRecv::where('id','=',$mail_id)->where('recvby','=',$user->id)->update(['isread' => 1]);
        return $temp;
    }

    public function update_log(Request $request){
        $read_list = explode(",", $request['read']);
        $delete_list = explode(",", $request['delete']);
        $user = Auth::user();
        MsgRecv::where('recvby','=',$user->id)->whereIn('id',$read_list)->update(['isread' => 1]);
        MsgRecv::where('recvby','=',$user->id)->whereIn('id',$delete_list)->update(['isdelete' => 1]);
        MsgSend::where('sendby','=',$user->id)->whereIn('id',$delete_list)->update(['isdelete' => 1]);
        return "success";
    }

    public function send_mail(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $to_list = $request['receiver'];
        $record = array();

        $success_list = array();
        $not_found_list = array();
        $wrong_format_list = [];
        $temp_list = array();

        if($to_list == ""){
            $record['status'] = "receiver is null";
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
                            if(strpos($email[0],'group.') !== false){
                                if(Auth::user()->role <= 1)
                                {
                                    $group = explode("group.", $email[0]);
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
                                array_push($not_found_list, $email[0]);
                            }
                        }
                        else{
                            array_push($wrong_format_list, $item);
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
            $record['status'] = "server return success status";
            return $record;
        }
        
    }

    public function save_draft(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $id      = $request['id'];
        $user = Auth::user();
        if($id < 0) {
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
        }
        else{
            $date = date('Y-m-d H:i:s');
            $message = Messages::find($id);
            $message->title = $title;
            $message->content = $content;
            $message->created_at = $date;
            $message->save();
        }
        $record['status'] = "Server return Success";
        return $record;
    }

    public function send_draftmail(Request $request){
        $content = $request['content'];
        $title   = $request['title'];
        $to_list = $request['receiver'];
        $id      = $request['id'];
        $record = array();

        $success_list = array();
        $not_found_list = array();
        $wrong_format_list = [];
        $temp_list = array();

        if($to_list == ""){
            $record['status'] = "receiver is null";
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
                            if(strpos($email[0],'group.') !== false){
                                if(Auth::user()->role <= 1)
                                {
                                    $group = explode("group.", $email[0]);
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
                                array_push($not_found_list, $email[0]);
                            }
                        }
                        else{
                            array_push($wrong_format_list, $item);
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
                if($id < 0){
                    $message = new Messages;
                    $message->content = $content;
                    $message->title = $title;
                    $message->created_at = $date;
                    $message->save();
                }
                else{
                    $message = Messages::find($id);
                    $message->content = $content;
                    $message->title = $title;
                    $message->created_at = $date;
                    $message->save();
                }
                
                foreach ($success_list as $key => $value) {
                    $msg_recv = new MsgRecv;
                    $msg_recv->recvby = $value->id;
                    $msg_recv->isdelete = 0;
                    $msg_recv->isread = 0;
                    $msg_recv->id = $message->id;
                    $msg_recv->save();
                }
                if($id < 0){
                    $user = Auth::user();
                    $msg_send = new MsgSend;
                    $msg_send->id = $message->id;
                    $msg_send->sendby = $user->id;
                    $msg_send->isdelete = 0;
                    $msg_send->isdraft = 0;  
                    $msg_send->save();
                }
                else{
                    $msg_send = MsgSend::find($id);
                    $msg_send->isdraft = 0;
                    $msg_send->save();
                }
                
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
            $record['status'] = "server return success status";
            return $record;
        }
    }

}
