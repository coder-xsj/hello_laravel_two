<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //一条博文只能属于一个用户
    public function user(){
        return $this->belongsTo(User::class);
    }
}
