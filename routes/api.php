<?php

use Illuminate\Support\Facades\Route;

// join minitutor
Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');

// minitutor request video
Route::prefix('minitutor')->as('minitutor.')->group(function(){
    Route::post('request-videos/{id}/hero', 'Minitutor\RequestVideosController@updateHero')->name('request-videos.update.hero');
    Route::post('request-videos/{id}/video', 'Minitutor\RequestVideosController@uploadVideo')->name('request-videos.upload.video');
    Route::delete('request-videos/{playlist_id}/video/{video_id}', 'Minitutor\RequestVideosController@destroyVideo')->name('request-videos.destroy.video');
    Route::resource('request-videos', 'Minitutor\RequestVideosController')->except(['create', 'edit', 'show']);
});
