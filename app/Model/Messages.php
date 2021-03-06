<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = ['id', 'title' , 'content', 'created_at'];
    public $timestamps = false;

    public function send_by(){
    	return $this->hasOne('App\Model\MsgSend', 'id','id');
    }

}
