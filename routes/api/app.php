<?php

use Illuminate\Support\Facades\Route;

Route::get('join-minitutor', 'JoinMinitutorController@show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status');
Route::post('join-minitutor', 'JoinMinitutorController@store');

Route::get('categories', 'CategoriesController@index');
Route::get('categories/{slug}', 'CategoriesController@show');

Route::get('articles', 'ArticlesController@index');
Route::get('articles/{slug}', 'ArticlesController@show');

Route::get('playlists', 'PlaylistsController@index');
Route::get('playlists/{slug}', 'PlaylistsController@show');

Route::post('comments/{type}/{id}', 'CommentsController@store');

Route::get('feedback/{type}/{id}', 'FeedbackController@show');
Route::post('feedback/{type}/{id}', 'FeedbackController@store');

Route::post('follow/{minitutor_id}', 'FollowController@store');
Route::delete('follow/{minitutor_id}', 'FollowController@destroy');

Route::post('favorites/{type}/{id}', 'FavoritesController@store');
Route::delete('favorites/{type}/{id}', 'FavoritesController@destroy');

Route::get('minitutors', 'MinitutorsController@index');
Route::get('minitutors/{username}', 'MinitutorsController@show');

Route::get('users', 'UsersController@index');
Route::get('users/most-points', 'UsersController@mostPoints');
Route::get('users/{idOrUsername}', 'UsersController@show');
