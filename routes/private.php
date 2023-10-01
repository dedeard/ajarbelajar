<?php

use Illuminate\Support\Facades\Route;

Route::get('/histories', 'HistoriesController@index')->name('histories');
