<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MsgRecv extends Model
{
    protected $table = 'msgrecv';
    protected $fillable = ['id', 'recv_by' , 'isread', 'isdelete'];
    public $timestamps = false;

    public function content()
    {
        return $this->hasOne('App\Model\Messages' , 'id', 'id');
    }

}
