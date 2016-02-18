<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Closure;

class Role_Teacher
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->check())
        {
            $user = $this->auth->user();
            if($user->role != 1)
            {
                return Redirect('/');
            }
            else
            {
                return $next($request);
            }
            
        }
        else{
            return Redirect('/');
        }
    }
}
