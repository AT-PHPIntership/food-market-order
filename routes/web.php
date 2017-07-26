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
    return view('admin.users.list-users');
});

Route::get('/users/user-info', function () {
    return view('admin.users.user-info');
});

Route::get('/users/create-user', function () {
    return view('admin.users.create-user');
});

Route::get('/users/update-user', function () {
    return view('admin.users.update-user');
});

Route::get('/categories', function () {
    return view('admin.categories.list-categories');
});
Route::get('/detail-category', function () {
    return view('admin.categories.list-categories');
})->name('detail-category');

Route::get('/edit-category', function () {
    return view('admin.categories.list-categories');
})->name('edit-category');

Route::get('/food', function () {
    return view('admin.food.list-food');
});

Route::get('/detail-food', function () {
    return view('admin.food.list-food');
})->name('detail-food');

Route::get('/edit-food', function () {
    return view('admin.food.list-food');
})->name('edit-food');

Route::get('/material', function () {
    return view('admin.material.list-material');
});

Route::get('/detail-material', function () {
    return view('admin.material.list-material');
})->name('detail-material');

Route::get('/edit-food', function () {
    return view('admin.material.list-material');
})->name('edit-material');

Route::get('/orders', function () {
    return view('admin.orders.list-orders');
});

Route::get('/detail-order', function () {
    return view('admin.orders.list-orders');
})->name('detail-order');