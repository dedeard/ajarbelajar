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

Route::get('feedback/{type}/{id}/show', 'FeedbackController@show');
Route::post('feedback/{type}/{id}', 'FeedbackController@store');

Route::post('follow/{minitutor_id}', 'FollowController@store');
Route::delete('follow/{minitutor_id}', 'FollowController@destroy');
