<?php

use Illuminate\Support\Facades\Route;

Route::get('join-minitutor', 'JoinMinitutorController@show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status');
Route::post('join-minitutor', 'JoinMinitutorController@store');

Route::get('categories', 'CategoriesController@index');
Route::get('categories/{slug}', 'CategoriesController@show');

Route::post('follow/{minitutor_id}', 'FollowController@store');
Route::delete('follow/{minitutor_id}', 'FollowController@destroy');
