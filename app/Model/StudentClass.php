<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table    = 'studentclass';
    protected $fillable = ['class_id', 'student_id' , 'conduct', 'ispass', 'note'];
    public $timestamps  = false;

    public function student()
    {
        return $this->hasOne('App\Model\Student' , 'id','student_id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Model\Classes' , 'id', 'class_id');
    }

}
