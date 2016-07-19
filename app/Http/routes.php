<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Auth::guest())
        return redirect('/login');
    else
        return redirect('/home');
});

Route::auth();
Route::get('/home', 'HomeController@index');
Route::post('/send', 'HomeController@saveAnswer');
Route::get('/answered', 'HomeController@answered');
Route::get('/users', 'HomeController@users');
Route::post('/users/save', 'HomeController@saveUser');
Route::get('/users/delete/{id}', 'HomeController@deleteUser');
Route::get('/users/restore/{id}', 'HomeController@restoreUser');

Route::get('/api/send/{asker}/{question}', 'ApiController@addQuestion');
Route::get('/api/status/{hash}', 'ApiController@getStatus');