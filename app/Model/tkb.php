<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tkb extends Model
{
    protected $table = 'tkb';
    protected $fillable = ['teacher_id','teacher_name', 'subject_name','homeroom_class', 'sotietconlai','T0', 'T1', 'T2', 'T3', 'T4', 'T5', 'T6','T7', 'T8', 'T9','T10', 'T11', 'T12', 'T13', 'T14', 'T15', 'T16','T17', 'T18', 'T19', 'T20', 'T21', 'T22','T23', 'T24', 'T25', 'T26','T27', 'T28','T29', 'T30', 'T31', 'T32', 'T33', 'T34', 'T35', 'T36','T37', 'T38', 'T39', 'T40', 'T41', 'T42', 'T43', 'T44', 'T45', 'T46','T47', 'T48', 'T49'];
    public $primaryKey = "teacher_id";
    public $timestamps = false;


    public function teacher(){
    	return $this->hasOne('App\Model\Teacher', 'id', 'teacher_id');
    }
}