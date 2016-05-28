<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = ['class_id', 'teacher_id', 'period', 'day'];
    public $timestamps = false;
    
    // public function user()
    // {
    //     return $this->belongsTo('App\User' , 'id', 'id');
    // }
}
// a