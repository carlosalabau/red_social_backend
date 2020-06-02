<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\posts;
use Faker\Generator as Faker;

$factory->define(Posts::class, function (Faker $faker) {
    return [
        'id_user'=>$faker->numberBetween(1,10),
        'titulo'=>$faker->sentence,
        'imagen'=>'https://picsum.photos/500/500?random='.$faker->numberBetween(1,100)
    ];
});
