<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['id', 'mobilephone' , 'homephone', 'group', 'position', 'incomingday', 'doable'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }

    public function my_position()
    {
        return $this->hasOne('App\Model\Position' , 'id', 'position');
    }

    public function classes()
    {
        return $this->hasMany('App\Model\Classes' , 'homeroom_teacher', 'id');
    }

    public function teach()
    {
        return $this->hasOne('App\Model\Subject' , 'id', 'group');
    }
}
