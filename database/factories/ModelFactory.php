<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_admin' => random_int(0,1),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Supplier::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Food::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(10, 100),
        'category_id' => $faker->randomElement(App\Category::pluck('id')->toArray()),
        'description' => $faker->paragraph,
        'image' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
$factory->define(App\DailyMenu::class, function (Faker\Generator $faker) {

    return [
        'food_id' => $faker->randomElement(App\Food::pluck('id')->toArray()),
        'quantity' => $faker->numberBetween(1, 10),
        'date' => $faker->date()
    ];
});

$factory->define(App\Material::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(10, 100),
        'category_id' => $faker->randomElement(App\Category::pluck('id')->toArray()),
        'description' => $faker->paragraph,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'supplier_id' => $faker->randomElement(App\Supplier::pluck('id')->toArray())
    ];
});

$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomElement(App\User::pluck('id')->toArray()),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'trans_at' => $faker->dateTime,
        'custom_address' => $faker->paragraph,
        'payment' => 10000,
        'status' => random_int(0, 3)
    ];
});

$factory->define(App\OrderItem::class, function (Faker\Generator $faker) {
    $rand = random_int(0, 1);
    if ($rand == 1) {
        return [
            'itemtable_id' => $faker->randomElement(App\Food::pluck('id')->toArray()),
            'itemtable_type' => 'food',
            'quantity' => random_int(1, 5)
        ];
    }
    else {
        return [
            'itemtable_id' => $faker->randomElement(App\Material::pluck('id')->toArray()),
            'itemtable_type' => 'material',
            'quantity' => random_int(1, 5)
        ];
    }
});
