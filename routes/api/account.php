<?php

use Illuminate\Support\Facades\Route;

Route::delete('logout', 'LogoutController@logout');
Route::get('profile', 'ProfileController@get');
Route::put('profile', 'ProfileController@put');
Route::post('avatar', 'AvatarController@post');
Route::post('broadcast', 'PusherController@broadcast');
