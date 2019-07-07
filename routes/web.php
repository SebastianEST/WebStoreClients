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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/client', 'RequestController@getClient');


Route::post('/client', 'RequestController@getClient');

Route::get('/users/connectuser', 'UserController@connectUser');

Route::resource('/users', 'UserController');


#for queries by webuser
Route::get('/usr', 'WebUserController@index');

Route::post('/usr', 'WebUserController@getUsers');