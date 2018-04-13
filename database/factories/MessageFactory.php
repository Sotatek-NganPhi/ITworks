<?php

$factory->define(App\Models\Message::class, function (Faker\Generator $faker) {
    return [
        'applicant_id' => $faker->numberBetween(1, 20),
        'content' => $faker->name.PHP_EOL.' '.$faker->name,
        'title' => 'Test mail inbox Test mail inbox Test mail inbox Test mail inbox Test mail inbox Test mail inbox',
        'type' => 0,
        'metadata' => $faker->name,
        'from' => 'manager',
        'user_id' => 1,
        'manager_id' => 1,
        'is_read' => $faker->numberBetween(0, 1),
        'is_favorite' => 0
    ];
});