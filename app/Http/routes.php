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

Route::get('/', '\App\Http\Controllers\HomeController@index');
Route::get('/todolist', '\App\Http\Controllers\HomeController@list');
Route::post('/add-todo', '\App\Http\Controllers\HomeController@store');
Route::delete('/delete-todo/{id}', '\App\Http\Controllers\HomeController@destroy');
