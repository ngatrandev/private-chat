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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/user/{user}/storesession', 'SessionController@store');
//Muốn dùng id của user để tương thích với Controller phải viết đúng {user}
Route::patch('/sessions/{session}/update', 'SessionController@update');

Route::get('/getinvites', 'HomeController@getInvites');
Route::get('/getfriends', 'HomeController@getFriends');


