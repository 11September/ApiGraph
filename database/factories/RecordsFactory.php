<?php

use App\User;
use Faker\Generator as Faker;

$users = User::all();

$unixTimestap = '1461067200';

$factory->define(App\Record::class, function (Faker $faker) use ($users) {
    return [
        'user_id' => App\User::all()->random()->id,
        'activity_id' => 1,
        'value' => $faker->randomFloat(null, 1, 50),
        'date' => $faker->dateTimeBetween('-1 years',  '+0 days'),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
