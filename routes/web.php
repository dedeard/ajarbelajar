<?php

use Illuminate\Support\Facades\Route;

// Base Route
Route::get('/', 'HomeController@index')->name('home');
Route::get('/article', 'HomeController@article')->name('article');
Route::get('/video', 'HomeController@video')->name('video');


// Footer link route
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/constructive-feedback', 'HomeController@constructiveFeedback')->name('constructiveFeedback');


// Show tag routes
Route::get('/tags/{slug}', 'TagsController@show')->name('tags');


// Users routes
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/@{username}', function($username){ return redirect()->route('users.activity', $username); })->name('users.show');
Route::get('/users/@{username}/activity', 'UsersController@activity')->name('users.activity');
Route::get('/users/@{username}/favorite', 'UsersController@favorite')->name('users.favorite');
Route::get('/users/@{username}/following', 'UsersController@following')->name('users.following');


// Notifications routes
Route::middleware(['auth'])->prefix('notifications')->as('notifications.')->group(function(){
    Route::get('/', 'NotificationsController@index')->name('index');
    Route::get('/markAsRead', 'NotificationsController@markAsRead')->name('markasread');
    Route::get('/destroy', 'NotificationsController@destroy')->name('destroy');
    Route::get('/{id}', 'NotificationsController@read')->name('read');
});


// Show posts routes
Route::prefix('post')->as('post.')->group(function(){
    Route::get('/{slug}', 'PostController@show')->name('show');
    Route::middleware(['auth'])->post('/{id}/comment', 'PostController@storeComment')->name('comment.store');
    Route::middleware(['auth'])->post('/{id}/review', 'PostController@storeReview')->name('review.store');
});


// Follow minitutor routes
Route::middleware(['auth'])->prefix('followable')->as('followable.')->group(function(){
    Route::get('/{id}/follow', 'FollowController@follow')->name('follow');
    Route::get('/{id}/unfollow', 'FollowController@unFollow')->name('unfollow');
});


// Favorite routes
Route::middleware(['auth'])->prefix('favorite')->as('favorite.')->group(function(){
    Route::get('/{id}/create', 'FavoriteController@create')->name('create');
    Route::get('/{id}/delete', 'FavoriteController@destroy')->name('destroy');
});


// Categories routes
Route::prefix('category')->as('category.')->group(function(){
    Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/{slug}', 'CategoryController@show')->name('show');
});


// show minitutor routes
Route::get('/minitutor', 'MinitutorController@index')->name('minitutor.index');
Route::prefix('@{username}')->as('minitutor.')->group(function(){
    Route::get('/', function($username){ return redirect()->route('minitutor.info', $username); })->name('show');
    Route::get('info', 'MinitutorController@info')->name('info');
    Route::get('videos', 'MinitutorController@videos')->name('videos');
    Route::get('articles', 'MinitutorController@articles')->name('articles');
    Route::get('followers', 'MinitutorController@followers')->name('followers');
});


// Join minitutor routes
Route::prefix('join-minitutor')->as('join.minitutor.')->group(function(){
    Route::get('/', 'JoinMinitutorController@index')->name('index');
    Route::middleware(['auth', 'is.not.minitutor'])->group(function(){
        Route::get('create', 'JoinMinitutorController@create')->name('create');
        Route::post('store', 'JoinMinitutorController@store')->name('store');
    });
});


Route::middleware('auth')->group(function(){
    // MyDashboard routes
    Route::prefix('dashboard/me')->as('dashboard.me.')->namespace('MyDashboard')->group(function(){
        Route::get('/', function(){ return redirect()->route('dashboard.me.activity.index'); })->name('index');
        Route::get('activity', 'ActivityController@index')->name('activity.index');
        Route::get('edit', 'EditController@index')->name('edit.index');
        Route::put('edit', 'EditController@update')->name('edit.update');
        Route::get('favorite', 'FavoriteController@index')->name('favorite.index');
        Route::get('following', 'FollowingController@index')->name('following.index');
    });

    // MinitutorDashboard routes
    Route::middleware(['is.minitutor', 'minitutor:active'])->prefix('dashboard/minitutor')->as('dashboard.minitutor.')->namespace('MinitutorDashboard')->group(function(){
        Route::get('/', function(){ return redirect()->route('dashboard.minitutor.edit.index'); })->name('index');
        Route::get('/accepted', 'AcceptedController@index')->name('accepted.index');
        Route::get('/accepted/{slug}', 'AcceptedController@preview')->name('accepted.preview');
        Route::get('/followers', 'FollowersController@index')->name('followers.index');
        Route::get('/reviews', 'ReviewsController@index')->name('reviews.index');
        Route::get('/comments', 'CommentsController@index')->name('comments.index');
        Route::get('/edit', 'EditController@index')->name('edit.index');
        Route::put('/edit', 'EditController@update')->name('edit.update');
        // article route
        Route::post('/articles/{id}/image', 'ArticlesController@image')->name('articles.upload-image');
        Route::get('/articles/{id}/publish-toggle', 'ArticlesController@publishToggle')->name('articles.publish.toggle');
        Route::resource('/articles', 'ArticlesController')->except('show');
        // video route
        Route::post('/videos/{id}/video', 'VideosController@uploadVideo')->name('videos.upload-video');
        Route::delete('/videos/{id}/video/{video_id}', 'VideosController@destroyVideo')->name('videos.destroy-video');
        Route::get('/videos/{id}/publish-toggle', 'VideosController@publishToggle')->name('videos.publish.toggle');
        Route::resource('/videos', 'VideosController')->except('show');
    });
});
