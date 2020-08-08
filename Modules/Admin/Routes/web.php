<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@index');
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
