<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', function () {
    return view('login');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/report', "LogController@report");