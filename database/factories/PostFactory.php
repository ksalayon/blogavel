<?php

use Faker\Provider\HtmlLorem;
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

$factory->define(App\Posts::class, function (Faker $faker) {
    $title = $faker->title;
    return [
        'title' => $title,
        'body' => $faker->randomHtml(2,3),
        'slug' => str_slug($title), // secret
        'updated_at' => date("Y-m-d H:i:s"),
        'created_at' => date("Y-m-d H:i:s"),
    ];
});
