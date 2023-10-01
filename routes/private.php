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
