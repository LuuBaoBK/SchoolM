<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Response;
use Auth;
use App\User;
use App\Model\Subject;
class MobileAuthController extends ApiGuardController
{
    protected $apiMethods = [
        'login' => [
            'keyAuthentication' => false,
            'logged' => false
        ]
    ];
    public function login(Request $request){
        $token = csrf_token();
        $data = explode("|", $request['data']);
        $email = $data['0'];
        $password = $data['1'];
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $token = User::find(Auth::user()->id)->api_key->key;
            $user = User::find(Auth::user()->id);
            $user->token = $token;

            $return_data['id'] = $user->id;
            $return_data['email'] = $user->id."@schoolm.com";
            $return_data['role'] = (string)$user->role;
            $return_data['fullname'] = $user->fullname;
            $return_data['token'] = $token;
            if($user->role == 3){
                $return_data['numchild'] = count($user->parent->student);
                $return_data['children'] = array();
                foreach ($user->parent->student as $key => $value) {
                    $temp['ma'] = $value->id;
                    $temp['fullname'] = $value->user->fullname;
                    array_push($return_data['children'], $temp);
                }  
            }
            // $return_data['fullname'] = "abc";
            return $return_data;
        }
        else{
            return Response::json(array(
                'error' => false,
                'status_code' => 201,
                'data' => "Id or Password is incorrect",
            ));
        }
    }

    public function get_user_info(){
        $user = Auth::user();
        $role = $user->role;
        $data = array();
        switch ($role) {
            case 0:
                // phone address
                $data['mobilephone'] = $user->admin->mobilephone;
                $data['address'] = $user->address;
                $data['avatar'] = "empty";
            case 1:
                // mobile phone, home phone, gender, address, group
                $src = "/uploads/teachers/".$user->id;
                if(file_exists(".".$src.".jpg")){
                    $src = substr($src, 1).".jpg";
                }
                else if(file_exists(".".$src.".png")){
                    $src = substr($src, 1).".png";
                }
                else{
                    $src = "empty";
                }
                $data['avatar'] = $src;
                $data['mobilephone'] = $user->teacher->mobilephone;
                $data['homephone'] = $user->teacher->homephone;
                $data['gender'] = ($user->gender == "M") ? "Male" : "Female";
                $data['address'] = $user->address;
                $data['group'] = Subject::find($user->teacher->group)->subject_name;
                break;
            case 2:
                // date of birth, gender, parent(fullname , homephone, mobile phone, address )
                $src = "/uploads/".$user->student->enrolled_year."/".$user->id;
                if(file_exists(".".$src.".jpg")){
                    $src = substr($src, 1).".jpg";
                }
                else if(file_exists(".".$src.".png")){
                    $src = substr($src, 1).".png";
                }
                else{
                    $src = "empty";
                }
                $data['avatar'] = $src;
                $dateofbirth = date_create($user->dateofbirth);
                $dateofbirth = date_format($dateofbirth, "d/m/Y");
                $data['dateofbirth'] = $dateofbirth;
                $data['gender'] = ($user->gender == "M") ? "Male" : "Female";
                $data['parent'] = $user->student->parent->user->fullname;
                $data['mobilephone'] = $user->student->parent->mobilephone;
                $data['homephone'] = $user->student->parent->homephone;
                $data['address'] = $user->student->parent->user->address;
                break;
            case 3:
                $data['avatar'] = "empty";
                $data['mobilephone'] = $user->parent->mobilephone;
                $data['homephone'] = $user->parent->homephone;
                $data['job'] = $user->parent->job;
                $data['address'] = $user->address;
                break;
            
            default:
                # code...
                break;
        }
        return $data;
    }
}
