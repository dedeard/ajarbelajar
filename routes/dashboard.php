<?php

use Illuminate\Support\Facades\Route;

Route::get('/activities', 'ActivitiesController@index')->name('activities');
Route::get('/edit-profile', 'EditProfileController@index')->name('edit-profile');
Route::put('/edit-profile', 'EditProfileController@update')->name('edit-profile');
Route::get('/edit-password', 'EditPasswordController@index')->name('edit-password');
Route::put('/edit-password', 'EditPasswordController@update')->name('edit-password');

Route::resource('/lessons', 'LessonsController');
Route::post('/lessons/{lesson}/cover', 'LessonsController@updateCover')->name('lessons.update.cover');
Route::put('/lessons/{lesson}/index', 'LessonsController@updateIndex')->name('lessons.update.index');
Route::post('/lessons/{lesson}/episode', 'LessonsController@uploadEpisode')->name('lessons.store.episode');
Route::get('/lessons/{lesson}/{episode}/edit', 'EpisodesController@edit')->name('lessons.episode.edit');
Route::put('/lessons/{lesson}/{episode}', 'EpisodesController@update')->name('lessons.episode.update');
Route::delete('/lessons/{lesson}/{episode}', 'EpisodesController@destroy')->name('lessons.episode.destroy');

Route::get('/favorites', 'FavoritesController@index')->name('favorites');
Route::put('/favorites/{lesson}/toggle', 'FavoritesController@toggle')->name('favorites.toggle');

Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
Route::get('/notifications/markall', 'NotificationsController@markall')->name('notifications.markall');
Route::get('/notifications/{id}', 'NotificationsController@read')->name('notifications.read');
