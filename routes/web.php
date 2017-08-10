<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('users', 'UserController');

Route::resource('categories', 'CategoryController');

Route::resource('suppliers', 'SupplierController');

Route::resource('daily-menus', 'DailyMenuController');

Route::resource('foods', 'FoodController');

Route::resource('materials', 'MaterialController');

Route::resource('orders', 'OrderController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::post('/daily-menus/getFoodList', 'DailyMenuController@storeNewMenu'); //route for ajax request

Route::post('/daily-menus/editMenuItem', 'DailyMenuController@updateMenuItem'); //route for ajax request

Route::post('/daily-menus/deleteMenuItem', 'DailyMenuController@deleteMenuItem'); //route for ajax request
