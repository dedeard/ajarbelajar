<?php

use Illuminate\Support\Facades\Route;

Route::get('/activities', 'ActivitiesController@index')->name('activities');
Route::get('/edit-profile', 'EditProfileController@index')->name('edit-profile');
Route::put('/edit-profile', 'EditProfileController@update')->name('edit-profile');
Route::get('/edit-password', 'EditPasswordController@index')->name('edit-password');
Route::put('/edit-password', 'EditPasswordController@update')->name('edit-password');

Route::resource('/lessons', 'LessonsController');
Route::post('/lessons/{lesson}/cover', 'LessonsController@updateCover')->name('lessons.update.cover');
Route::post('/lessons/{lesson}/episode', 'LessonsController@uploadEpisode')->name('lessons.store.episode');
Route::put('/lessons/{lesson}/description', 'LessonsController@updateDescription')->name('lessons.update.description');

Route::resource('/articles', 'ArticlesController');
Route::post('/articles/{article}/cover', 'ArticlesController@updateCover')->name('articles.update.cover');
Route::put('/articles/{article}/content', 'ArticlesController@updateContent')->name('articles.update.content');
