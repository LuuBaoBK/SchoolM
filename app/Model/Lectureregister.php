<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lectureregister extends Model
{
    protected $table = 'lectureregister';
    protected $fillable = ['id', 'teacher_id' , 'title', 'level', 'wrote_date', 'day', 'content'];
    public $timestamps = false;

    public function notice_classes()
    {
        return $this->hasMany('App\Model\Classlectureregister' , 'id', 'id');
    }

    public function wrote_by()
    {
        return $this->hasOne('App\Model\Teacher' , 'id', 'teacher_id');
    }
}
