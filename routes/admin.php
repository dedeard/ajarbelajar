<?php

use Illuminate\Support\Facades\Route;

// admin access
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


// manage permission
Route::resource('permissions', 'PermissionsController')->except(['show']);


// manage role
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
Route::resource('roles', 'RolesController')->except(['show']);
