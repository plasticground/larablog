<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('topics', 'TopicController');

Route::resource('profile', 'ProfileController')->except(
    'store',
    'create',
    'destroy'
);

Route::resource('comment', 'CommentController')->only(
    'store',
    'destroy'
);

Route::group(['prefix' => 'admin'], function(){
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/topics', 'AdminController@topics')->name('admin.topics');
    Route::resource('/categories', 'CategoryController')->except('show');
    Route::resource('/tags', 'TagController')->except('show');
});


