<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Label;
use App\Task;
use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name($nbWords =2, $variableNbWords = true),
        'task_id'=>factory(Task::class)->create(),
    ];
});
