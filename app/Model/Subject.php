<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model 
{
    protected $table = 'subjects';
    protected $fillable = ['id', 'name' , "totaltime"];
    public $timestamps = false;
    public function schedule()
    {
        return $this->beLongtoMany('App\Schedule', 'subject_id', 'id');
    }
}