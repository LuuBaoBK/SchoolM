<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Model\Parents;
use App\Model\Classes;

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
