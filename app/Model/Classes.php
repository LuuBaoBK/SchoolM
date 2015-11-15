<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table    = 'classes';
    protected $fillable = ['id', 'semester' , 'classname', 'homeroom_teacher'];
    public $timestamps  = false;

    public function students()
    {
        return $this->hasMany('App\Model\StudentClass' , 'class_id', 'id');
    }

    public function teacher()
    {
        return $this->hasOne('App\Model\Teacher' , 'id', 'homeroom_teacher');   
    }
}
