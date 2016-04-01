<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Role_Parent
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
            if($user->role != 3)
            {
                return Redirect('/permission_denied');
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
