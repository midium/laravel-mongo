<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
    Route::get('/todo', 'HomeController@todo');
    Route::get('/info', 'HomeController@info');

    Route::post('/add_comment', 'HomeController@addComment');
    Route::get('/delete_comment/{id}', 'HomeController@deleteComment');

    Route::post('/add_task', 'HomeController@addTask');
    Route::get('/delete_task/{id}', 'HomeController@deleteTask');
    Route::get('/task_done/{id}/{done}', 'HomeController@doneTask');
    Route::get('/clear_done', 'HomeController@clearDoneTask');

});
