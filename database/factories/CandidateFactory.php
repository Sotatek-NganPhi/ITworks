<?php

$factory->define(App\Models\Candidate::class, function (Faker\Generator $faker) {
    return [
        'final_academic_school' => $faker->name,
        'graduated_at' => Carbon\Carbon::now(),
        'toeic' => $faker->numberBetween(0, 200),
        'toefl' => $faker->numberBetween(0, 200),
        'language_experience_id' => $faker->numberBetween(1, 6),
        'language_conversation_level_id' => $faker->numberBetween(1, 3),
    ];
});