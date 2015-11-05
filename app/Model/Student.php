<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'enrolled_year' , 'graduated_year', 'parent_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo('App\User' , 'id', 'id');
    }

     public function parent()
    {
        return $this->hasOne('App\Model\Parents' , 'id' ,'parent_id');
    }
}
