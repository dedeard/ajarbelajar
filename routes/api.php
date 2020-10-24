<?php

use Illuminate\Support\Facades\Route;

// join minitutor
Route::get('join-minitutor', 'JoinMinitutorController@show')->name('join.minitutor.show');
Route::get('join-minitutor/status', 'JoinMinitutorController@status')->name('join.minitutor.status');
Route::post('join-minitutor', 'JoinMinitutorController@store')->name('join.minitutor.store');


Route::prefix('minitutor')->as('minitutor.')->group(function(){
    // minitutor request playlist
    Route::post('request-playlists/{id}/hero', 'RequestPlaylistsController@updateHero')->name('request-playlists.update.hero');
    Route::post('request-playlists/{id}/video', 'RequestPlaylistsController@uploadVideo')->name('request-playlists.upload.video');
    Route::put('request-playlists/{id}/index', 'RequestPlaylistsController@updateIndex')->name('request-playlists.update.index');
    Route::delete('request-playlists/{playlist_id}/video/{video_id}', 'RequestPlaylistsController@destroyVideo')->name('request-playlists.destroy.video');
    Route::resource('request-playlists', 'RequestPlaylistsController')->except(['create', 'edit', 'show', 'index']);

    // minitutor request article
    Route::post('request-articles/{id}/hero', 'RequestArticlesController@updateHero')->name('request-articles.update.hero');
    Route::post('request-articles/{id}/image', 'RequestArticlesController@uploadImage')->name('request-articles.upload.image');
    Route::resource('request-articles', 'RequestArticlesController')->except(['create', 'edit', 'show', 'index']);
});


// Category
Route::get('categories/popular', 'CategoriesController@popular')->name('categories.popular');
Route::resource('categories', 'CategoriesController')->only(['index', 'show']);


// Comment
Route::post('comments/{type}/{id}', 'CommentsController@store')->name('comments.store');


// feedback
Route::get('feedback/{type}/{id}/show', 'FeedbackController@show')->name('feedback.show');
Route::post('feedback/{type}/{id}', 'FeedbackController@store')->name('feedback.store');


// Playlists
Route::get('playlists/popular', 'PlaylistsController@popular')->name('playlists.popular');
Route::get('playlists/news', 'PlaylistsController@news')->name('playlists.news');
Route::resource('playlists', 'PlaylistsController')->only(['index', 'show']);


// Articles
Route::get('articles/popular', 'ArticlesController@popular')->name('articles.popular');
Route::get('articles/news', 'ArticlesController@news')->name('articles.news');
Route::resource('articles', 'ArticlesController')->only(['index', 'show']);


// follow minitutor
Route::post('follow/{minitutor_id}', 'FollowController@store')->name('follow.store');
Route::delete('follow/{minitutor_id}', 'FollowController@destroy')->name('follow.destroy');


// favorite minitutor
Route::post('favorites/{type}/{id}', 'FavoritesController@store')->name('favorites.store');
Route::delete('favorites/{type}/{id}', 'FavoritesController@destroy')->name('favorites.destroy');


// users
Route::get('users/most-points', 'UsersController@mostPoints');
Route::resource('users', 'UsersController')->only(['index', 'show']);


// minitutor
Route::resource('minitutors', 'MinitutorsController')->only(['index', 'show']);


// Search
Route::get('search', 'SearchController@index')->name('search');


// Notifications
Route::get('notifications/read/{id}', 'NotificationsController@read')->name('notifications.read');
Route::get('notifications/read', 'NotificationsController@markAsRead')->name('notifications.read_all');
Route::delete('notifications', 'NotificationsController@destroy')->name('notifications.destroy');


// SEO
Route::get('seos', 'SeosController@index')->name('seos.index');
