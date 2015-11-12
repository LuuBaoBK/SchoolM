<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['id', 'mobilephone' , 'homephone', 'group', 'position', 'incomingday'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }
}
