<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'email', 'password', 'role', 'fullname', 'dateofbirth', 'address', 'gender' ];

    protected $hidden = ['password', 'remember_token'];

    public function admin()
    {
        return $this->hasOne('App\Model\Admin' , 'id' ,'id');
    }

    public function teacher()
    {
        return $this->hasOne('App\Model\Teacher' , 'id' ,'id');
    }
    
    public function student()
    {
        return $this->hasOne('App\Model\Student' , 'id' ,'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Model\Parents' , 'id' ,'id');
    }

    public function msg_send()
    {
        return $this->hasMany('App\Model\MsgSend' , 'sendby' ,'id');
    }

    public function msg_recv()
    {
        return $this->hasMany('App\Model\MsgRecv' , 'recvby' ,'id');
    }

    public function api_key(){
        return $this->hasOne('App\Model\ApiKey','user_id','id');
    }
}