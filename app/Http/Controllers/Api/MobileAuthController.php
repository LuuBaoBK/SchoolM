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
            switch ($user->role) {
                case '0':
                    $private_data = $user->admin;
                    break;
                case '1':
                    $user->teacher->group = Subject::find($user->teacher->group)->subject_name;
                    $user->teacher->position = $user->teacher->my_position->position_name;
                    $private_data = $user->teacher;
                    break;
                case '2':
                    $private_data = $user->student;
                    break;
                case '3':
                    $private_data = $user->parent;
                    break;                
                default:
                    # code...
                    break;
            }
            return Response::json(array(
                'error' => false,
                'status_code' => 200,
                'data' => $user,
            ));
        }
        else{
            return Response::json(array(
                'error' => false,
                'status_code' => 201,
                'data' => "Id or Password is incorrect",
            ));
        }
    }
    public function info(){
        $auth = Auth::user();
        return $auth;
    }
}
