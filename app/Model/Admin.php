<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = ['id', 'ownername'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }
}
