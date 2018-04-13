<?php

$factory->define(App\Models\Candidate::class, function (Faker\Generator $faker) {
    return [
        'is_married' => $faker->numberBetween(0, 1),
        'current_situation_id' => $faker->numberBetween(1, 2),
        'final_academic_school' => $faker->name,
        'graduated_at' => Carbon\Carbon::now(),
        'toeic' => $faker->numberBetween(0, 200),
        'toefl' => $faker->numberBetween(0, 200),
        'platform_flag' => pow(2, $faker->numberBetween(0, 1)),
        'language_experience_id' => $faker->numberBetween(1, 6),
        'language_conversation_level_id' => $faker->numberBetween(1, 3),
        'driver_license_id' => $faker->numberBetween(1, 2),
        'jumping_condition_id' => $faker->numberBetween(1, 4),
        'jumping_date_id' => $faker->numberBetween(1, 5),
        'worked_companies_number' => $faker->numberBetween(1, 500),
        'lastest_company_name' => $faker->name,
        'lastest_industry_id' => $faker->numberBetween(1, 4),
        'lastest_company_size_id' => $faker->numberBetween(1, 5),
        'lastest_annual_income' => $faker->numberBetween(1, 200),
        'lastest_position_id' => $faker->numberBetween(1, 7),
        'lastest_employment_mode_id' => $faker->randomElement([1001, 1002, 1003, 1004, 1005, 1006, 2001]),
        'lastest_job_description' => $faker->text,
    ];
});