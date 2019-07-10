<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Replie;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'introduction' => $faker->sentence(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'title' => $faker->sentence(),
        'body' => $faker->text(),
        'user_id' => rand(1, 20),
        'category_id' => rand(1, 4),
        'excerpt' => $faker->sentence(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
$factory->define(App\Models\Replie::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();
    // 所有用户 ID 数组，如：[1,2,3,4]
    $user_ids = User::all()->pluck('id')->toArray();

    // 所有话题 ID 数组，如：[1,2,3,4]
    $topic_ids = Topic::all()->pluck('id')->toArray();
    return [
        'topic_id' => $topic_ids[mt_rand(0, count($topic_ids) - 1)],
        'user_id' =>  $user_ids[mt_rand(0, count( $user_ids) - 1)],
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
