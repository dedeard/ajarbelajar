<?php

Auth::routes([ 'verify' => true ]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/article', 'HomeController@article')->name('article');
Route::get('/video', 'HomeController@video')->name('video');

Route::prefix('post')->as('post.')->group(function(){
    Route::get('/{slug}', 'PostController@show')->name('show');

    Route::middleware(['auth'])->post('/{id}/comment', 'PostController@storeComment')->name('comment.store');
    Route::middleware(['auth'])->post('/{id}/review', 'PostController@storeReview')->name('review.store');
});

Route::middleware(['auth'])->prefix('followable')->as('followable.')->group(function(){
    Route::get('/{id}/follow', 'FollowController@follow')->name('follow');
    Route::get('/{id}/unfollow', 'FollowController@unFollow')->name('unfollow');
});

Route::middleware(['auth'])->prefix('favorite')->as('favorite.')->group(function(){
    Route::get('/{id}/create', 'FavoriteController@create')->name('create');
    Route::get('/{id}/delete', 'FavoriteController@destroy')->name('destroy');
});

Route::prefix('category')->as('category.')->group(function(){
    Route::get('/', 'CategoryController@index')->name('index');
    Route::get('/{slug}', 'CategoryController@show')->name('show');
});


Route::get('/minitutor/join', 'Minitutor\JoinMinitutorController@index')->name('minitutor.join.index');
Route::middleware('auth')->group(function(){
    // Dashboard routes
    Route::prefix('dashboard')->as('dashboard.')->group(function(){
        Route::get('/', 'DashbaordController@index')->name('index');

        Route::get('/edit', 'DashbaordController@edit')->name('edit');
        Route::put('/update', 'DashbaordController@update')->name('update');

        Route::get('/following', 'DashbaordController@following')->name('following');
        Route::get('/settings', 'DashbaordController@following')->name('settings');
        Route::get('/favorite', 'DashbaordController@favorite')->name('favorite');
    });

    Route::middleware(['is.minitutor', 'minitutor:active'])->namespace('Dashboard')->prefix('dashboard')->as('dashboard.')->group(function(){
        Route::resource('/article', 'ArticleController')->except(['show', 'create']);

        Route::resource('/video', 'VideoController')->except(['show', 'create']);

        Route::get('/followers', 'FollowersController@index')->name('followers.index');

        Route::get('/accepted', 'AcceptedController@index')->name('accepted.index');
        Route::get('/requested', 'RequestedController@index')->name('requested.index');
        Route::get('/requested/{id}/{type}/create', 'RequestedController@create')->name('requested.create');
        Route::get('/requested/{id}/{type}/destroy', 'RequestedController@destroy')->name('requested.destroy');
        Route::get('/review', 'ReviewController@index')->name('review.index');
        Route::get('/comments', 'CommentsController@index')->name('comments.index');
    });




    Route::prefix('minitutor')->as('minitutor.')->group(function(){

        // join to minitutor routes
        Route::middleware('is.not.minitutor')->namespace('Minitutor')->prefix('join')->as('join.')->group(function(){
            
            Route::get('/create', 'JoinMinitutorController@create')->name('create');
            Route::post('/store', 'JoinMinitutorController@store')->name('store');
            Route::get('/edit', 'JoinMinitutorController@edit')->name('edit');
            Route::put('/update', 'JoinMinitutorController@update')->name('update');
        });
    });
});


Route::prefix('minitutor')->as('minitutor.')->group(function(){
    Route::get('/', 'MinitutorController@index')->name('index');
    Route::get('/{username}', 'MinitutorController@show')->name('show');
});