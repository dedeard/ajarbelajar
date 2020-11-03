<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', 'DashboardController@index')->name('dashboard');


// Profile
Route::get('profile', 'ProfileController@index')->name('profile.index');
Route::get('profile/logout', 'ProfileController@logout')->name('profile.logout');


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

    Route::get('{id}/playlists', 'MinitutorsController@showPlaylists')->name('show.playlists');
    Route::get('{id}/articles', 'MinitutorsController@showArticles')->name('show.articles');
    Route::get('{id}/followers', 'MinitutorsController@showFollowers')->name('show.followers');
    Route::get('{id}/comments', 'MinitutorsController@showComments')->name('show.comments');
    Route::get('{id}/feedback', 'MinitutorsController@showFeedback')->name('show.feedback');
});
Route::resource('minitutors', 'MinitutorsController')->except(['create', 'store']);


// manage permission
Route::resource('permissions', 'PermissionsController')->except(['show']);


// manage role
Route::get('roles/toggle-sync-permission/{role_id}/{permission_id}', 'RolesController@toggleSyncPermission')->name('roles.toggle.sync.permission');
Route::resource('roles', 'RolesController')->except(['show']);


// manage seo
Route::resource('seos', 'SeosController')->except(['show']);


// manage seo
Route::resource('pages', 'PagesController')->except(['show']);

// Handele Froala fileManager
Route::get('froala/image', 'FroalaController@getImage')->name('froala.image');
Route::post('froala/image', 'FroalaController@uploadImage');
Route::delete('froala/image', 'FroalaController@destroyImage');


// manage email
Route::get('emails', 'EmailsController@index')->name('emails.index');
Route::get('emails/broadcast', 'EmailsController@broadcast')->name('emails.broadcast');
Route::post('emails/broadcast', 'EmailsController@sendBroadcastEmails');
Route::get('emails/private', 'EmailsController@private')->name('emails.private');
Route::post('emails/private', 'EmailsController@sendPrivateEmail');
