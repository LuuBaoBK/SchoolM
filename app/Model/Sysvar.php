<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Sysvar extends Model
{
    protected $table = 'sysvar';
    protected $fillable = ['id', 'value'];
    public $timestamps = false;
    
}
