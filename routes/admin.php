<?php

Route::get('/dashboard', function(){
  return redirect()->route('admin.user.index');
})->name('dashboard');


Route::resource('/user', 'UserController');

Route::prefix('minitutor')->as('minitutor.')->group(function(){
  Route::get('/', 'MinitutorController@index')->name('index');
  Route::delete('/{id}', 'MinitutorController@destroy')->name('destroy');
  Route::get('/{id}/active/toggle', 'MinitutorController@activeToggle')->name('active.toggle');

  Route::get('/request', 'RequestMinitutorController@index')->name('request.index');
  Route::get('/request/{id}', 'RequestMinitutorController@show')->name('request.show');
  Route::put('/request/{id}/accept', 'RequestMinitutorController@accept')->name('request.accept');
  Route::put('/request/{id}/reject', 'RequestMinitutorController@reject')->name('request.reject');
});

Route::resource('/categories', 'CategoriesController')->except('show');

Route::prefix('article')->as('article.')->group(function(){
  route::get('/', 'ArticleController@index')->name('index');
  route::get('/{id}/edit', 'ArticleController@edit')->name('edit');
  route::put('/{id}', 'ArticleController@update')->name('update');
  route::delete('/{id}', 'ArticleController@destroy')->name('destroy');
  route::get('/{id}/make-public', 'ArticleController@makePublic')->name('make.public');
  route::get('/{id}/make-draf', 'ArticleController@makeDraf')->name('make.draf');

  route::get('/requested', 'ArticleController@requested')->name('requested');
  route::get('/requested/{id}', 'ArticleController@showRequested')->name('requested.show');
  route::get('/requested/{id}/accept', 'ArticleController@acceptRequest')->name('requested.accept');
  route::get('/requested/{id}/reject', 'ArticleController@rejectRequest')->name('requested.reject');
});

Route::prefix('video')->as('video.')->group(function(){
  route::get('/', 'VideoController@index')->name('index');
  route::get('/{id}/edit', 'VideoController@edit')->name('edit');
  route::put('/{id}', 'VideoController@update')->name('update');
  route::delete('/{id}', 'VideoController@destroy')->name('destroy');
  route::get('/{id}/make-public', 'VideoController@makePublic')->name('make.public');
  route::get('/{id}/make-draf', 'VideoController@makeDraf')->name('make.draf');

  route::get('/requested', 'VideoController@requested')->name('requested');
  route::get('/requested/{id}', 'VideoController@showRequested')->name('requested.show');
  route::get('/requested/{id}/accept', 'VideoController@acceptRequest')->name('requested.accept');
  route::get('/requested/{id}/reject', 'VideoController@rejectRequest')->name('requested.reject');
});