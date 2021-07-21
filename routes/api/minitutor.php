<?php

use Illuminate\Support\Facades\Route;

Route::put('profile', 'ProfileController@update');

// request playlist
Route::post('request-playlists/{id}/hero', 'RequestPlaylistsController@updateHero');
Route::post('request-playlists/{id}/video', 'RequestPlaylistsController@uploadVideo');
Route::put('request-playlists/{id}/index', 'RequestPlaylistsController@updateIndex');
Route::delete('request-playlists/{playlist_id}/video/{video_id}', 'RequestPlaylistsController@destroyVideo');
Route::resource('request-playlists', 'RequestPlaylistsController')->except(['create', 'edit']);

// request article
Route::post('request-articles/{id}/hero', 'RequestArticlesController@updateHero');
Route::post('request-articles/{id}/image', 'RequestArticlesController@uploadImage');
Route::resource('request-articles', 'RequestArticlesController')->except(['create', 'edit']);
