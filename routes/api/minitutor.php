<?php

use Illuminate\Support\Facades\Route;

Route::put('profile', 'ProfileController@update');

// request article
Route::post('request-articles/{id}/hero', 'RequestArticlesController@updateHero');
Route::post('request-articles/{id}/image', 'RequestArticlesController@uploadImage');
Route::resource('request-articles', 'RequestArticlesController')->except(['create', 'edit']);

// request video
Route::post('request-videos/{id}/hero', 'RequestVideosController@updateHero');
Route::post('request-videos/{id}/video', 'RequestVideosController@uploadVideo');
Route::resource('request-videos', 'RequestVideosController')->except(['create', 'edit']);

// comments
Route::get('comments', 'CommentsController@index');

// feedback
Route::get('feedback', 'FeedbackController@index');
