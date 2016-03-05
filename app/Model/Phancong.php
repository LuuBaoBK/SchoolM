<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Phancong extends Model
{
    //
    protected $table = 'phancong';
    protected $fillable = ['teacher_id', 'class_id'];
    public $timestamps = false;

    public function teacher(){
    	return $this->belongsTo("App\Model\Teacher", "teacher_id",  "id");
    }

    public function classes(){
    	return $this->belongsTo("App\Model\Classes", "class_id", "id");
    }


}

