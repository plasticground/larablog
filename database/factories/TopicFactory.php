<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'body' => $faker->text,
        'user_id' => 1,
        'category_id' => 1,
        'status' => 1,
        'views' => $faker->numberBetween(0, 1000),
        'is_featured' => 0
    ];
});
