<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function() {
    Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
    Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
    Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');
});
