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


// manage minitutor
Route::prefix('minitutors')->as('minitutors.')->group(function(){
    Route::get('{id}/active-toggle', 'MinitutorsController@activeToggle')->name('active.toggle');
    Route::get('requests', 'MinitutorsController@requests')->name('requests');
    Route::get('request/{id}', 'MinitutorsController@showRequest')->name('request.show');
    Route::put('request/{id}/accept', 'MinitutorsController@acceptRequest')->name('request.accept');
    Route::put('request/{id}/reject', 'MinitutorsController@rejectRequest')->name('request.reject');

    Route::get('{id}/videos', 'MinitutorsController@showVideos')->name('show.videos');
    Route::get('{id}/articles', 'MinitutorsController@showArticles')->name('show.articles');
    Route::get('{id}/followers', 'MinitutorsController@showFollowers')->name('show.followers');
    Route::get('{id}/comments', 'MinitutorsController@showComments')->name('show.comments');
    Route::get('{id}/feedback', 'MinitutorsController@showFeedback')->name('show.feedback');
});
Route::resource('minitutors', 'MinitutorsController')->except(['create', 'store']);
