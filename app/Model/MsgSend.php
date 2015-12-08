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

}
