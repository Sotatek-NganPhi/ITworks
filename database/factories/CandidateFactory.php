<?php

$factory->define(App\Models\Candidate::class, function (Faker\Generator $faker) {
    return [
        'final_academic_school' => $faker->name,
        'graduated_at' => Carbon\Carbon::now(),
        'education'=> $faker->name,
        'language' => $faker->name,
        'language_level' => $faker->name,
    ];
});