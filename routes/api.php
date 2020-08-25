<?php

use Illuminate\Support\Facades\Route;

// join minitutor
Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');


Route::prefix('minitutor')->as('minitutor.')->group(function(){
    // minitutor request playlist
    Route::post('request-playlists/{id}/hero', 'Minitutor\RequestPlaylistsController@updateHero')->name('request-playlists.update.hero');
    Route::post('request-playlists/{id}/video', 'Minitutor\RequestPlaylistsController@uploadVideo')->name('request-playlists.upload.video');
    Route::put('request-playlists/{id}/index', 'Minitutor\RequestPlaylistsController@updateIndex')->name('request-playlists.update.index');
    Route::delete('request-playlists/{playlist_id}/video/{video_id}', 'Minitutor\RequestPlaylistsController@destroyVideo')->name('request-playlists.destroy.video');
    Route::resource('request-playlists', 'Minitutor\RequestPlaylistsController')->except(['create', 'edit', 'show']);

    // minitutor request article
    Route::post('request-articles/{id}/hero', 'Minitutor\RequestArticlesController@updateHero')->name('request-articles.update.hero');
    Route::post('request-articles/{id}/image', 'Minitutor\RequestArticlesController@uploadImage')->name('request-articles.upload.image');
    Route::resource('request-articles', 'Minitutor\RequestArticlesController')->except(['create', 'edit', 'show']);
});


// Category
Route::resource('categories', 'CategoriesController')->only(['index', 'show']);


// Comment
Route::get('comments/{type}/{id}', 'CommentsController@index')->name('comments.index');
Route::post('comments/{type}/{id}', 'CommentsController@store')->name('comments.store');
