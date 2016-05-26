<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MsgSend extends Model
{
    protected $table = 'msgsend';
    protected $fillable = ['id', 'sendby' , 'isdraft', 'isdelete'];
    public $timestamps = false;

    public function content()
    {
        return $this->hasOne('App\Model\Messages' , 'id', 'id');
    }

    public function recv_by(){
    	return $this->hasMany('App\Model\MsgRecv', 'id','id');
    }

    public function author(){
        return $this->belongsTo('App\User','sendby','id');
    }

}
