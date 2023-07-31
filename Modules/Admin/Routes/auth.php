<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('login', 'AuthenticatedSessionController@create')->name('login');
    Route::post('login', 'AuthenticatedSessionController@store');

    Route::get('forgot-password', 'PasswordResetLinkController@create')->name('password.request');
    Route::post('forgot-password', 'PasswordResetLinkController@store')->name('password.email');

    Route::get('reset-password/{token}', 'NewPasswordController@create')->name('password.reset');
    Route::post('reset-password', 'NewPasswordController@store')->name('password.store');
});

Route::middleware('admin')->group(function () {
    Route::get('confirm-password', 'ConfirmablePasswordController@show')->name('password.confirm');
    Route::post('confirm-password', 'ConfirmablePasswordController@store');

    Route::post('logout', 'AuthenticatedSessionController@destroy')->name('logout');
});
