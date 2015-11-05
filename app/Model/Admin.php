<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'ownername'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }
}
