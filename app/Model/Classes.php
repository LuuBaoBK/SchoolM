<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table    = 'classes';
    protected $fillable = ['id', 'scholastic' , 'classname', 'homeroom_teacher', 'doable_from', 'doable_to', 'doable_type'];
    public $timestamps  = false;

    public function students()
    {
        return $this->hasMany('App\Model\StudentClass' , 'class_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Model\Teacher' , 'homeroom_teacher', 'id');   
    }

}
