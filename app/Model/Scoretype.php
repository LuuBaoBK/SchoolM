<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scoretype extends Model
{
    protected $table    = 'Scoretype';
    protected $fillable = ['id', 'subject_id', 'type' , 'factor', 'applyfrom', 'month'];
    public $timestamps  = false;
}
