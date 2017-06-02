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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'tipo' => rand(0, 1) ? 'admin' : 'comum', 
        'status' => 'ativo',
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
    ];
});


$factory->define(App\Fornecedor::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'endereco' => $faker->paragraph,
        'cnpj' => strval(rand(1,100000))
    ];
});

$factory->define(App\Produto::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,
        'descricao' => $faker->paragraph,
        'preco' => rand(1, 100000),
        'quantidade' => rand(1, 100000),
        'fornecedor_id' => factory('App\Fornecedor')->create()->id
    ];
});