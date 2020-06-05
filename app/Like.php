<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table ='likes';
    protected $fillable = ['id','id_post','id_user'];
}
