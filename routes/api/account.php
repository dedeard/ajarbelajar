<?php

use Illuminate\Support\Facades\Route;

Route::delete('logout', 'LogoutController@logout');
Route::get('profile', 'ProfileController@show');
Route::put('profile', 'ProfileController@update');
Route::post('avatar', 'AvatarController@upload');
Route::post('broadcast', 'PusherController@broadcast');

Route::get('notifications/read/{id}', 'NotificationsController@read');
Route::get('notifications/read', 'NotificationsController@markAsRead');
Route::delete('notifications', 'NotificationsController@destroy');
