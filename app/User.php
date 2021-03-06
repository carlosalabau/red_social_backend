<?php

namespace App;

use App\Post;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    public function posts(){
        return $this->hasMany('App\Post','id_user');
    }
    public function likes(){
        return $this->belongsToMany('App\Post', 'likes', 'id_user', 'id_post');
    }
    public function coments(){
        return $this->hasMany('App\Comment', 'id_user');
    }
    public function followers(){
        return $this->belongsToMany('App\User', 'followers','id_follower','id_followed');
    }
    public function following(){
        return $this->belongsToMany('App\User', 'followers','id_followed','id_follower');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
