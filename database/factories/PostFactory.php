<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $status = [
        'publish',
        'draft',
        'pending',
    ];
    $title = $faker->text(rand(55, 128));

    return [
        'author_id' => 1,
        'category_id' => 1,
        'title' => $faker->text(255),
        'slug' => Str::slug($title),
        'excerpt' => $faker->realText(255),
        'body' => $faker->realText(2048),
        'status' => $status[rand(0, 2)],
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
        'featured' => boolval(rand(0, 2048)) ? 1 : 0,
    ];
});