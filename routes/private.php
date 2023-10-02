<?php

use Illuminate\Support\Facades\Route;

Route::get('/histories', 'HistoriesController@index')->name('histories');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings/update-profile', 'SettingsController@updateProfile')->name('settings.update-profile');
Route::post('/settings/update-password', 'SettingsController@updatePassword')->name('settings.update-password');

Route::get('/favorites', 'FavoritesController@index')->name('favorites');
Route::put('/favorites/{lesson}/toggle', 'FavoritesController@toggle')->name('favorites.toggle');

Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
Route::get('/notifications/markall', 'NotificationsController@markall')->name('notifications.markall');
Route::get('/notifications/{id}', 'NotificationsController@read')->name('notifications.read');

Route::resource('my-lessons', 'MyLessonsController');
Route::post('my-lessons/{my_lesson}/cover', 'MyLessonsController@updateCover')->name('my-lessons.update.cover');
Route::put('my-lessons/{my_lesson}/index', 'MyLessonsController@updateIndex')->name('my-lessons.update.index');
Route::post('my-lessons/{my_lesson}/episode', 'MyLessonsController@uploadEpisode')->name('my-lessons.store.episode');
Route::get('my-lessons/{my_lesson}/{episode}/edit', 'EpisodesController@edit')->name('my-lessons.episode.edit');
Route::put('my-lessons/{my_lesson}/{episode}', 'EpisodesController@update')->name('my-lessons.episode.update');
Route::delete('my-lessons/{my_lesson}/{episode}', 'EpisodesController@destroy')->name('my-lessons.episode.destroy');

Route::post('subtitles/{episode}', 'SubtitlesController@store')->name('subtitles.store');
Route::delete('subtitles/{subtitle}', 'SubtitlesController@destroy')->name('subtitles.destroy');
