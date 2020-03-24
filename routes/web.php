<?php

Auth::routes([ 'verify' => true ]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/article', 'HomeController@article')->name('article');
Route::get('/video', 'HomeController@video')->name('video');

Route::middleware(['auth'])->prefix('notifications')->as('notifications.')->group(function(){
    Route::get('/', 'NotificationsController@index')->name('index');

    Route::middleware(['auth'])->post('/{id}/comment', 'PostController@storeComment')->name('comment.store');
    Route::middleware(['auth'])->post('/{id}/review', 'PostController@storeReview')->name('review.store');
});

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


Route::prefix('minitutor')->as('minitutor.')->group(function(){
    Route::get('/', 'MinitutorController@index')->name('index');
    Route::get('/{username}', 'MinitutorController@show')->name('show');
});

Route::prefix('join-minitutor')->as('join.minitutor.')->group(function(){
    Route::get('/', 'JoinMinitutorController@index')->name('index');
    Route::middleware(['auth', 'is.not.minitutor'])->group(function(){
        Route::get('create', 'JoinMinitutorController@create')->name('create');
        Route::post('store', 'JoinMinitutorController@store')->name('store');
        Route::get('edit', 'JoinMinitutorController@edit')->name('edit');
        Route::put('update', 'JoinMinitutorController@update')->name('update');
    });
});


Route::middleware('auth')->group(function(){
    // Dashboard routes
    Route::prefix('dashboard')->as('dashboard.')->namespace('Dashboard')->group(function(){
        Route::get('/', function(){
            return redirect()->route('dashboard.edit');
        })->name('index');
        Route::get('edit', 'EditController@index')->name('edit');
        Route::put('edit/update', 'EditController@update')->name('update');

        Route::get('following', 'FollowingController@index')->name('following');
        Route::get('favorite', 'FavoriteController@index')->name('favorite');
    });

    Route::middleware(['is.minitutor', 'minitutor:active'])->namespace('Dashboard')->prefix('dashboard')->as('dashboard.')->group(function(){
        Route::resource('/article', 'ArticleController')->except(['show', 'create']);

        Route::resource('/video', 'VideoController')->except(['show', 'create']);

        Route::get('/followers', 'FollowersController@index')->name('followers.index');

        Route::get('/accepted', 'AcceptedController@index')->name('accepted.index');
        Route::get('/requested', 'RequestedController@index')->name('requested.index');
        Route::get('/requested/{id}/create', 'RequestedController@create')->name('requested.create');
        Route::get('/requested/{id}/destroy', 'RequestedController@destroy')->name('requested.destroy');
        Route::get('/review', 'ReviewController@index')->name('review.index');
        Route::get('/comments', 'CommentsController@index')->name('comments.index');
    });

});
