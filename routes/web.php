<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

	Route::group(['middleware' => 'auth'], function () {

		Route::get('/dashboard', [
            'uses'       => 'Admin\DashboardController@index',
            'as'		 => 'admin.dashboard'
        ]);

        Route::get('/configuration', [
            'uses'       => 'Admin\UserController@index',
            'as'         => 'admin.configuration'
        ]);

		Route::get('/users', [
            'uses'       => 'Admin\UserController@index',
            'as'		 => 'admin.users'
        ]);

        Route::get('/modules', [
            'uses'       => 'Admin\ModuleController@index',
            'as'         => 'admin.modules'
        ]);
	});
    

    Auth::routes();

    Route::get('/', 'HomeController@index')->middleware('auth');
});