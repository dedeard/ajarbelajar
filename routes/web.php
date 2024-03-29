<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/search', 'SearchController@search')->name('search');
Route::post('/search', 'SearchController@search')->name('search');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('lessons', 'LessonsController')->only(['index', 'show']);
Route::get('lessons/{lesson}/watch', 'LessonsController@watch')->name('lessons.watch');

Route::get('comments/{episode}', 'CommentsController@index')->name('comments.index');
Route::post('comments/{episode}', 'CommentsController@store')->name('comments.store');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
Route::get('comments/{comment}/like-toggle', 'CommentsController@likeToggle')->name('comments.like-toggle');

Route::resource('categories', 'CategoriesController')->only(['index', 'show']);

Route::get('users', 'UsersController@index')->name('users.index');
Route::get('@{user}', 'UsersController@show')->name('users.show');

Route::post('markdown/preview', 'MarkdownController@preview')->name('markdown.preview');

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    require __DIR__ . '/private.php';
});
