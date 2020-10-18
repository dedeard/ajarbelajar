<?php

use Illuminate\Support\Facades\Route;

Route::post('register', 'RegisterController@register')->name('register');
Route::post('login', 'LoginController@login')->name('login');

Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

Route::post('password/reset', 'ResetPasswordController@request')->name('password.request');
Route::get('password/reset', 'ResetPasswordController@check')->name('password.check');
Route::put('password/reset', 'ResetPasswordController@update')->name('password.update');

Route::delete('logout', 'LogoutController@logout')->name('logout');

Route::get('user', 'UserController@index')->name('user.index');
Route::put('user', 'UserController@update')->name('user.update');
Route::put('user/minitutor', 'UserController@updateMinitutor')->name('user.update.minitutor');
Route::post('user/avatar', 'UserController@updateAvatar')->name('user.update.avatar');

Route::post('broadcast', 'UserController@broadcast')->name('broadcast');
