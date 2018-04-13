<?php

$factory->defineAs(App\User::class, 'normal', function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'name_phonetic' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'first_name_phonetic' => $faker->name,
        'last_name_phonetic' => $faker->name,
        'postal_code' => '123-4567',
        'address' => $faker->address,
        'phone_number' => $faker->numerify("###-####-####"),
        'line_id' => $faker->randomNumber,
        'gender' => $faker->randomElement(['male', 'female']),
        'birthday' => Carbon\Carbon::now(),
        'mail_receivable' => 1,
        'confirmed' => 1,
        'confirmation_code' => NULL,
    ];
});