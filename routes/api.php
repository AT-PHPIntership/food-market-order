<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('/users/me', 'Api\UserController@show');

});

Route::post('/users', 'Api\UserController@store');

Route::resource('foods', 'Api\FoodController', ['only' => [
    'index', 'show'
]]);
