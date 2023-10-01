<?php

use Illuminate\Support\Facades\Route;

Route::resource('/lessons', 'LessonsController');
Route::post('/lessons/{lesson}/cover', 'LessonsController@updateCover')->name('lessons.update.cover');
Route::put('/lessons/{lesson}/index', 'LessonsController@updateIndex')->name('lessons.update.index');
Route::post('/lessons/{lesson}/episode', 'LessonsController@uploadEpisode')->name('lessons.store.episode');
Route::get('/lessons/{lesson}/{episode}/edit', 'EpisodesController@edit')->name('lessons.episode.edit');
Route::put('/lessons/{lesson}/{episode}', 'EpisodesController@update')->name('lessons.episode.update');
Route::delete('/lessons/{lesson}/{episode}', 'EpisodesController@destroy')->name('lessons.episode.destroy');

Route::post('/subtitles/{episode}', 'SubtitlesController@store')->name('subtitles.store');
Route::delete('/subtitles/{subtitle}', 'SubtitlesController@destroy')->name('subtitles.destroy');

Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
Route::get('/notifications/markall', 'NotificationsController@markall')->name('notifications.markall');
Route::get('/notifications/{id}', 'NotificationsController@read')->name('notifications.read');
