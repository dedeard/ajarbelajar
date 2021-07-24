<?php

use Illuminate\Support\Facades\Route;

// admin access
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


// manage permission
Route::resource('permissions', 'PermissionsController')->except(['show']);


// manage role
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
Route::resource('roles', 'RolesController')->except(['show']);


// manage user
Route::prefix('users/{id}/minitutor')->as('users.minitutor.')->group(function(){
    Route::get('/create', 'UsersController@createMinitutor')->name('create');
    Route::post('/', 'UsersController@storeMinitutor')->name('store');
});
Route::get('users/{id}/followings', 'UsersController@showFollowings')->name('users.show.followings');
Route::get('users/{id}/favorites', 'UsersController@showFavorites')->name('users.show.favorites');
Route::resource('users', 'UsersController');
