<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classlectureregister extends Model
{
    protected $table = 'classlectureregister';
    protected $fillable = ['id', 'class_id', 'classname', 'notice_date'];
    public $timestamps = false;

    public function notice_detail()
    {
        return $this->belongsTo('App\Model\Lectureregister' , 'id', 'id');
    }
}
