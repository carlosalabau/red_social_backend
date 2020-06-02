<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    public function user(){
        return $this->belongsTo('App\User','id_user');
    }
    public function likes(){
        return $this->belongsToMany('App\User', 'likes', 'id_post', 'id_user');
    }
}

