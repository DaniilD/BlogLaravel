<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->sentence,
        'image' => '54QSD3VlwT.jpeg',
        'date' => '08/09/17',
        'views' =>$faker->numberBetween(0, 5000),
        'category_id'=> 1,
        'user_id'=>1,
        'status'=>0,
        'is_featured'=>0,

    ];
});
