<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model 
{
    protected $table = 'subjects';
    protected $fillable = ['id', 'subject_name' , "totaltime"];
    public $timestamps = false;
    public function schedule()
    {
        return $this->beLongtoMany('App\Schedule', 'subject_id', 'id');
    }

    public function members()
    {
        return $this->hasMany('App\Model\Teacher', 'group', 'id');
    }

    public function score_type()
    {
        return $this->hasMany('App\Model\Scoretype', 'subject_id', 'id');
    }
}