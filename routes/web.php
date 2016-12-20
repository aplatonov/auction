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

Auth::routes();

Route::get('home', 'HomeController@index');
Route::get('userlots', 'HomeController@indexUserLots');
Route::get('register/confirm/{confirmation_code}','AdvancedReg@confirm');
Route::resource('lots', 'LotController');
Route::post('bets/makebet','BetController@makeBet');
Route::resource('bets', 'BetController');

