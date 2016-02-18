<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scoretype extends Model
{
    protected $table    = 'Scoretype';
    protected $fillable = ['id', 'type' , 'factor'];
    public $timestamps  = false;
}
