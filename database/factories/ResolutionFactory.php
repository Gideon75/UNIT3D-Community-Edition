<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Resolution::class, function (Faker $faker) {
    return [
        'name'     => $faker->name,
        'slug'     => $faker->slug,
        'position' => $faker->randomNumber(),
    ];
});
