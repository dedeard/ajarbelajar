<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@index')->name('dashboard');

Route::resource('roles', 'RolesController')->except('show');
Route::get('roles/{role}/{permission}/toggle', 'RolesController@toggleSyncPermission')->name('roles.toggle_sync_permission');
