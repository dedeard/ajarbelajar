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

    // minitutor playlist
    Route::resource('playlists', 'Minitutor\PlaylistsController')->only('index');

    // minitutor article
    Route::resource('articles', 'Minitutor\ArticlesController')->only('index');
});


// Category
Route::resource('categories', 'CategoriesController')->only(['index', 'show']);


// Comment
Route::get('comments/{type}/{id}', 'CommentsController@index')->name('comments.index');
Route::post('comments/{type}/{id}', 'CommentsController@store')->name('comments.store');


// feedback
Route::get('feedback/{type}/{id}', 'FeedbackController@index')->name('feedback.index');
Route::post('feedback/{type}/{id}', 'FeedbackController@store')->name('feedback.store');


// Playlists
Route::get('playlists/{id}/view', 'PlaylistsController@storeView')->name('playlists.store.view');
Route::resource('playlists', 'PlaylistsController')->only(['index', 'show']);


// Articles
Route::get('articles/{id}/view', 'ArticlesController@storeView')->name('articles.store.view');
Route::resource('articles', 'ArticlesController')->only(['index', 'show']);


// follow minitutor
Route::get('follow/{user_id}', 'FollowController@index')->name('follow.index');
Route::post('follow/{minitutor_id}', 'FollowController@store')->name('follow.store');
Route::delete('follow/{minitutor_id}', 'FollowController@destroy')->name('follow.destroy');


// favorite minitutor
Route::get('favorites/{user_id}', 'FavoritesController@index')->name('favorites.index');
Route::post('favorites/{type}/{id}', 'FavoritesController@store')->name('favorites.store');
Route::delete('favorites/{type}/{id}', 'FavoritesController@destroy')->name('favorites.destroy');


// Activity
Route::resource('activities', 'ActivitiesController')->only('show');
