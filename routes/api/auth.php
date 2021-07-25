<?php

use Illuminate\Support\Facades\Route;

Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');

Route::post('password', 'PasswordController@request');
Route::get('password', 'PasswordController@check');
Route::put('password', 'PasswordController@update');
