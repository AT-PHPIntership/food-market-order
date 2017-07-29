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
    return view('admin.dashboard');
});

Route::get('/users', function () {
    return view('admin.users.list_users');
});
Route::get('/users/detail', function () {
    return view('admin.users.detail_user');
})->name('detail-user');
Route::get('/users/create', function () {
    return view('admin.users.create_user');
})->name('create-user');
Route::get('/users/update', function () {
    return view('admin.users.update_user');
})->name('update-user');
