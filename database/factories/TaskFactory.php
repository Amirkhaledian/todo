<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->title($nbWords =2, $variableNbWords = true),
        'description' => $faker->sentence($nbWords =2, $variableNbWords = true),
        'status'=>'open',
        'user_id'=>factory(User::class)->create(),
    ];
});
