<?php

use Illuminate\Support\Facades\Route;

Route::get('/activities', 'ActivitiesController@index')->name('activities');
Route::get('/edit-profile', 'EditProfileController@index')->name('edit-profile');
Route::get('/edit-password', 'EditPasswordController@index')->name('edit-password');
