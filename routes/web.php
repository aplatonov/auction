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
Route::get('userwinlots', 'HomeController@indexUserWinLots');
Route::get('blockedlots', 'HomeController@indexBlockedLots');
Route::get('category/{id}','HomeController@indexCategoryLots');
Route::get('register/confirm/{confirmation_code}','AdvancedReg@confirm');
Route::resource('lots', 'LotController');
Route::post('lots/paystatus/{id}','LotController@payStatus');
Route::post('bets/makebet','BetController@makeBet');
Route::resource('bets', 'BetController');

Route::get('/admin/users','AdminController@showUsers');
Route::delete('/admin/users/delete/{id}','AdminController@destroyUser');
Route::post('/admin/users/confirm/{id}','AdminController@confirmUser');
Route::post('/admin/users/block/{id}','AdminController@blockUser');
Route::post('/admin/users/role/{id}','AdminController@adminUser');

Route::get('/admin/lots','AdminController@showLots');
Route::delete('/admin/lots/delete/{id}','AdminController@deleteLot');
Route::post('/admin/lots/block/{id}','AdminController@blockLot');
Route::get('/admin/checklots','AdminController@checkLots');

Route::get('/admin/categories',['uses'=>'CategoryController@manageCategory']);
Route::post('/admin/categoryAdd', 'CategoryController@addCategory');

Route::get('contacts', 'EmailController@contacts');

Route::post('send', 'EmailController@send');