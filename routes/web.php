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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', 'UserController');

Route::resource('categories', 'CategoryController');

Route::resource('suppliers', 'SupplierController');

Route::get('foods/get-by-category', 'FoodController@getByCategory')->name('foods.get-by-category');

Route::resource('daily-menus', 'DailyMenuController');

Route::resource('foods', 'FoodController');

Route::resource('materials', 'MaterialController');

Route::resource('orders', 'OrderController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
