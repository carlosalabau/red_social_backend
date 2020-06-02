<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coments extends Model
{
    protected $table = 'coments';
    protected $fillable = [
        'id_post','id_user','coment'
    ];
}
