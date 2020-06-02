<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Coments;
use Faker\Generator as Faker;

$factory->define(Coments::class, function (Faker $faker) {
    return [
        'id_post'=>$faker->numberBetween(1,20),
        'id_user'=>$faker->numberBetween(1,10),
        'coment'=>$faker->realText(200)
    ];
});
