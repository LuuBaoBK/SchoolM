<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';
    protected $fillable = ['id', 'position_name'];
    public $timestamps = false;

    public function members()
    {
        return $this->hasMany('App\Model\Teacher' , 'position', 'id');
    }
}
