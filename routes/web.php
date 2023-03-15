<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('lessons', 'LessonsController')->only(['index', 'show']);
Route::get('lessons/{lesson}/watch', 'LessonsController@watch')->name('lessons.watch');

Route::resource('categories', 'CategoriesController')->only(['index', 'show']);

Route::get('users', 'UsersController@index')->name('users.index');
Route::get('@{user}', 'UsersController@show')->name('users.show');

require __DIR__ . '/auth.php';
