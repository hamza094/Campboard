<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

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



$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Project::class, function (Faker $faker) {
    $title = $faker->sentence;
        return [
           'user_id'=>function () {
            return factory('App\User')->create()->id;
        },  
        'title' => $title,
        'slug'=>str_slug($title),    
        'description' => $faker->paragraph,
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    return [
         'project_id'=>function () {
            return factory('App\Project')->create()->id;
        },
        'body' => $faker->sentence,
        'completed'=>'false'
    ];
});
