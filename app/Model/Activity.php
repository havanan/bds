<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity_log';
    protected $fillable = ['*'];


    public function getUser(){
        return $this->belongsTo('App\User','id','user_id');
    }

}
