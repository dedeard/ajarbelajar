<?php

use Illuminate\Support\Facades\Route;

// admin access
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Profile
Route::get('profile', 'ProfileController@index')->name('profile.index');
Route::get('profile/logout', 'ProfileController@logout')->name('profile.logout');


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



// manage requested article
Route::get('request-articles/{id}/accept', 'RequestArticlesController@accept')->name('request-articles.accept');
Route::resource('request-articles', 'RequestArticlesController')->only(['index', 'show', 'destroy']);


// manage article
Route::get('articles/minitutors', 'ArticlesController@minitutors')->name('articles.minitutors');
Route::post('articles/{id}/image', 'ArticlesController@uploadImage')->name('articles.upload.image');
Route::resource('articles', 'ArticlesController')->except('show');


// manage requested video
Route::get('request-videos/{id}/accept', 'RequestVideosController@accept')->name('request-videos.accept');
Route::resource('request-videos', 'RequestVideosController')->only(['index', 'show', 'destroy']);


// manage video
Route::get('videos/minitutors', 'VideosController@minitutors')->name('videos.minitutors');
Route::post('videos/{id}/upload-video', 'VideosController@uploadVideo')->name('videos.upload.video');
Route::resource('videos', 'VideosController')->except('show');


// manage comments
Route::get('comments/{id}/make-public', 'CommentsController@makePublic')->name('comments.make-public');
Route::resource('comments', 'CommentsController')->only(['index', 'destroy']);


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
