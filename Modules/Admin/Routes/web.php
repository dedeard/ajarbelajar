<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@index')->name('dashboard');
