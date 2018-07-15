<?php

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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@begin']);
    Route::get('/push', ['as' => 'push', 'uses' => 'HomeController@pushEvent']);

    Route::post('/newgame', ['as' => 'newgamev', 'uses' => 'HomeController@newGame']);

    Route::post('/hungr', ['as' => 'hungr', 'uses' => 'HomeController@hungr']);
    Route::post('/sleep', ['as' => 'sleep', 'uses' => 'HomeController@sleep']);
    Route::post('/care', ['as' => 'care', 'uses' => 'HomeController@care']);
    Route::post('/joy', ['as' => 'joy', 'uses' => 'HomeController@joy']);
    Route::post('/del', ['as' => 'del', 'uses' => 'HomeController@del']);
});