<?php

use Illuminate\Support\Facades\Route;

// join minitutor
Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');


Route::prefix('minitutor')->as('minitutor.')->group(function(){
    // minitutor request video
    Route::post('request-videos/{id}/hero', 'Minitutor\RequestVideosController@updateHero')->name('request-videos.update.hero');
    Route::post('request-videos/{id}/video', 'Minitutor\RequestVideosController@uploadVideo')->name('request-videos.upload.video');
    Route::delete('request-videos/{playlist_id}/video/{video_id}', 'Minitutor\RequestVideosController@destroyVideo')->name('request-videos.destroy.video');
    Route::resource('request-videos', 'Minitutor\RequestVideosController')->except(['create', 'edit', 'show']);

    // minitutor request article
    Route::post('request-articles/{id}/hero', 'Minitutor\RequestArticlesController@updateHero')->name('request-articles.update.hero');
    Route::post('request-articles/{id}/image', 'Minitutor\RequestArticlesController@uploadImage')->name('request-articles.upload.image');
    Route::resource('request-articles', 'Minitutor\RequestArticlesController')->except(['create', 'edit', 'show']);
});
