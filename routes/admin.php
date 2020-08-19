<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('dashboard');
})->name('dashboard');

// manage user
Route::prefix('users/{id}/minitutor')->as('users.minitutor.')->group(function(){
    Route::get('/create', 'UsersController@createMinitutor')->name('create');
    Route::post('/', 'UsersController@storeMinitutor')->name('store');
});
Route::resource('users', 'UsersController');

// manage minitutor
Route::prefix('minitutors')->as('minitutors.')->group(function(){
    Route::get('{id}/active-toggle', 'MinitutorsController@activeToggle')->name('active.toggle');
});
Route::resource('minitutors', 'MinitutorsController')->except(['create', 'store', 'edit']);

// manage permission
Route::resource('permissions', 'PermissionsController')->except(['show']);

// manage role
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
Route::resource('roles', 'RolesController')->except(['show']);
