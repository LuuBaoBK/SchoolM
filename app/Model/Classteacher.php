<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classteacher extends Model
{
   	protected $table    = 'classteacher';
    protected $fillable = ['class_id', 'teacher_id'];
    public $timestamps  = false;
}
