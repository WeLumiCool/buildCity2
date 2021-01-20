<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Desk;
use App\Program;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Desk::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random(),
        'program_id' => Program::all()->random(),
        'balance' => rand('10', '50000'),
        'code' => $faker->unique()->randomNumber(6),
        'is_closed' => rand(0, 1),
        'code'=>$faker->unique()->randomNumber(6),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
