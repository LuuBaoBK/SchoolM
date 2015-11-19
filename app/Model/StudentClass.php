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
        return $this->belongsTo('App\Model\Student' , 'student_id','id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Model\Classes' , 'class_id', 'id');
    }

}
