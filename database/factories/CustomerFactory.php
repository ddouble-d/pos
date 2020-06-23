<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'hp' => $faker->phoneNumber,
        'alamat' => $faker->address,
    ];
});
