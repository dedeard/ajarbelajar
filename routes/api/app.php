<?php

use Illuminate\Support\Facades\Route;

Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');

Route::get('categories', 'CategoriesController@index');

Route::get('articles', 'ArticlesController@index');
Route::get('articles/{slug}', 'ArticlesController@show');

Route::get('playlists', 'PlaylistsController@index');
Route::get('playlists/{slug}', 'PlaylistsController@show');
