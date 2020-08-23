<?php

use Illuminate\Support\Facades\Route;

Route::post('playlists/{playlist_id}/upload-video', 'PlaylistsController@uploadVideo')->name('playlists.upload.video');
Route::delete('playlists/{video_id}', 'PlaylistsController@destroyVideo')->name('playlists.destroy.video');

Route::post('articles/{id}/image', 'ArticlesController@uploadImage')->name('articles.upload.image');
