<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table    = 'api_keys';
    protected $fillable = ['id', 'key' , 'user_id'];
    public $timestamps  = false;
}
