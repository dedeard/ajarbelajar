<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::get('/login', 'AuthController@showLoginForm')->name('login');
    Route::post('/login', 'AuthController@login');
});

Route::middleware('auth')->post('/logout', 'AuthController@logout')->name('logout');
