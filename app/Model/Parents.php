<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';
    protected $fillable = ['id', 'mobilephone' , 'homephone', 'job'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }

    public function student()
    {
        return $this->hasMany('App\Model\Student' , 'parent_id', 'id');
    }
}
