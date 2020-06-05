<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Comment extends Model
{
    protected $guarded = [];
    public function post()
    {
        return $this->belongsTo('App\Post','id_post');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user');
    }
}
