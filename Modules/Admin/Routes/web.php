<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@index');
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');

Route::resource('permissions', 'PermissionsController')->except(['show']);

Route::resource('roles', 'RolesController')->except(['show']);
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
