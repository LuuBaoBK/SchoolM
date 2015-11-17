<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected   $table      = 'students';
    protected   $fillable   = ['id', 'enrolled_year' , 'graduated_year', 'parent_id'];
    public      $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Model\Parents','parent_id','id');
    }

    public function classes()
    {
        return $this->hasMany('App\Model\StudentClass' , 'student_id' ,'id');
    }
}
