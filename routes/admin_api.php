<?php

use Illuminate\Support\Facades\Route;

Route::post('/videos/{id}/upload', 'VideosController@upload')->name('videos.upload');
Route::delete('/videos/{id}', 'VideosController@destroy')->name('videos.destroy');

Route::post('articles/{id}/image', 'ArticlesController@uploadImage')->name('articles.upload.image');
