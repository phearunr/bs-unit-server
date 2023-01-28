<?php

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
        'phone_number' => '010'.$faker->unique()->randomNumber(6),
        'gender' => $faker->randomElement(['Male','Female']),
        'birthdate' => $faker->dateTimeBetween('-30 years', '-20 years'),
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});
