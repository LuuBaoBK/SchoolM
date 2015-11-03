<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'mobilephone' , 'homephone', 'job'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
