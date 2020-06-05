<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'nombre'=>$faker->name,
        'apellidos'=>$faker->lastName,
        'email'=>$faker->email,
        'password'=>$faker->password(6,20),
        'edad'=>$faker->numberBetween(18,66),
        'sexo'=>$faker->randomElement(['hombre','mujer','NC']),
        'imagen'=>'https://picsum.photos/500/500?random='.$faker->numberBetween(1,100),
        'imagen_perfil'=>'https://picsum.photos/1200/500?random='.$faker->numberBetween(1,100),
        'remember_token' => Str::random(10)
    ];
});
