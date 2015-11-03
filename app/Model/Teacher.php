<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'mobilephone' , 'homephone', 'group', 'position', 'incomingday'];

    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }
}
