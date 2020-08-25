<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('dashboard');
})->name('dashboard');

// manage comments
Route::get('comments/{id}/make-public', 'CommentsController@makePublic')->name('comments.make-public');
Route::resource('comments', 'CommentsController')->only(['index', 'destroy']);

// manage requested article
Route::get('request-articles/{id}/accept', 'RequestArticlesController@accept')->name('request-articles.accept');
Route::resource('request-articles', 'RequestArticlesController')->only(['index', 'show', 'destroy']);

// manage article
Route::get('articles/minitutors', 'ArticlesController@minitutors')->name('articles.minitutors');
Route::resource('articles', 'ArticlesController')->except('show');

// manage requested playlist
Route::get('request-playlists/{id}/accept', 'RequestPlaylistsController@accept')->name('request-playlists.accept');
Route::resource('request-playlists', 'RequestPlaylistsController')->only(['index', 'show', 'destroy']);

// manage playlist
Route::get('playlists/minitutors', 'PlaylistsController@minitutors')->name('playlists.minitutors');
Route::resource('playlists', 'PlaylistsController')->except('show');

// manage category
Route::resource('categories', 'CategoriesController')->except(['show']);

// manage user
Route::prefix('users/{id}/minitutor')->as('users.minitutor.')->group(function(){
    Route::get('/create', 'UsersController@createMinitutor')->name('create');
    Route::post('/', 'UsersController@storeMinitutor')->name('store');
});
Route::resource('users', 'UsersController');

// manage minitutor
Route::prefix('minitutors')->as('minitutors.')->group(function(){
    Route::get('{id}/active-toggle', 'MinitutorsController@activeToggle')->name('active.toggle');
    Route::get('requests', 'MinitutorsController@requests')->name('requests');
    Route::get('request/{id}', 'MinitutorsController@showRequest')->name('request.show');
    Route::put('request/{id}/accept', 'MinitutorsController@acceptRequest')->name('request.accept');
    Route::put('request/{id}/reject', 'MinitutorsController@rejectRequest')->name('request.reject');
});
Route::resource('minitutors', 'MinitutorsController')->except(['create', 'store', 'edit']);

// manage permission
Route::resource('permissions', 'PermissionsController')->except(['show']);

// manage role
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
Route::resource('roles', 'RolesController')->except(['show']);
