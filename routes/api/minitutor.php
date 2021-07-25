<?php

use Illuminate\Support\Facades\Route;

Route::put('profile', 'ProfileController@update');

// request article
Route::post('request-articles/{id}/hero', 'RequestArticlesController@updateHero');
Route::post('request-articles/{id}/image', 'RequestArticlesController@uploadImage');
Route::resource('request-articles', 'RequestArticlesController')->except(['create', 'edit']);
