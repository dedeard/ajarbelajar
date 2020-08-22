<?php

use Illuminate\Support\Facades\Route;

Route::get('/videos/{id}/can-upload', 'VideosController@canUpload')->name('videos.can-upload');
Route::post('/videos/{id}', 'VideosController@store')->name('videos.store');
Route::delete('/videos/{id}', 'VideosController@destroy')->name('videos.destroy');
