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
    Route::put('/users/me', 'Api\UserController@update');
    Route::get('/users/me', 'Api\UserController@show');
    Route::post('/orders', 'Api\OrderController@store');
    Route::delete('/orders/{id}', 'Api\OrderController@destroy');
    Route::get('/orders', 'Api\OrderController@index');
    Route::get('/orders/{id}/items', 'Api\OrderController@show');
    Route::post('/users/upload-image', 'Api\UserController@postUploadImage');
    Route::delete('/users/remove-image', 'Api\UserController@deleteImage');
    Route::put('/orders/{id}', 'Api\OrderController@update');
    Route::delete('/order-items/{id}', 'Api\OrderItemController@destroy');
});

Route::get('categories', 'Api\CategoryController@index');

Route::get('categories/{category_id}', 'Api\CategoryController@show');

Route::resource('daily-menus', 'Api\DailyMenuController', ['only' => [
    'index', 'show'
]]);
Route::post('/users', 'Api\UserController@store');

Route::resource('foods', 'Api\FoodController', ['only' => [
    'index', 'show'
]]);

Route::post('/users/login', 'Api\UserController@login');

Route::resource('materials', 'Api\MaterialController', ['only' => [
    'index', 'show'
]]);
Route::get('/statistics/counts', 'Api\StatisticController@countResources');
Route::get('/statistics/trends', 'Api\StatisticController@getTrends');

Route::get('/carts', 'Api\CartController@index');
