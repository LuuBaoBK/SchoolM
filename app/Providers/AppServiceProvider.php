<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Model\Parents;
use App\Model\Classes;
use Auth;
use View;
use App\Model\MsgRecv;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('greater_than', function($attribute, $value, $parameters, $validator) {
            $data = array_get($validator->getData(), $parameters[0]);
            
            return ($value >= $data) ; 
        });

        Validator::replacer('greater_than',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace([':other'], $parameters[0], $message);
        });

        Validator::extend('isexistparent', function($attribute, $value, $parameters, $validator) {
            $data = Parents::where("id",$value)->count();
            if($data > 0){
                return true;
            }
            else{
                return false;
            }
        });

        Validator::extend('isexistclasses', function($attribute, $value, $parameters, $validator) {
            $data = Classes::where("id",$value)->count();
            if($data <= 0){
                return true;
            }
            else{
                return false;
            }
        });

        Validator::extend('inrange', function($attribute, $value, $parameters, $validator) {
            $data_1 = $parameters[0];
            $data_2 = $parameters[1];
            
            if($data_1 <= $value && $value <= 2099 ){
                return true;
            }
            else{
                return false;
            }
        });
        Validator::replacer('inrange',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace([':min', ':max'], [$parameters[0], $parameters[1]], $message);
        });

        View::composer('*', function($view){
            $view->with('currentUser', Auth::user());
        });

        View::composer('*', function($view){
            $user = Auth::user();
            if($user != null){
                $mail_count = MsgRecv::where('recvby','=',$user->id)->where('isread','=',0)->where('isdelete','=',0)->count();
                $mail_count = ($mail_count == 0 ) ? "" : $mail_count;
                $view->with('mail_count', $mail_count);
            }

                
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
