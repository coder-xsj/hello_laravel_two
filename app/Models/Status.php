<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // 允许被更新的字段
    protected $fillable = ['content'];
    //一条博文只能属于一个用户
    public function user(){
        return $this->belongsTo(User::class);
    }
}
