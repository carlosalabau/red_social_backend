<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'id_post'=>$faker->numberBetween(1,50),
        'id_user'=>$faker->numberBetween(1,10),
        'comment'=>$faker->realText(200)
    ];
});
