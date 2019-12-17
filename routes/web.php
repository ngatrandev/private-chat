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
Route::get('/getgroups', 'HomeController@getGroups');

Route::post('/send/{session}', 'ChatController@storeMessage');
Route::post('/session/{session}/chats', 'ChatController@chats');
Route::post('/session/{session}/read', 'ChatController@read');
Route::post('/session/{session}/clear', 'ChatController@clear');
Route::post('/creategroup', 'GroupController@create');
Route::post('/groupsend/{group}', 'GroupChatController@storeMessage');
Route::post('/group/{group}/chats', 'GroupChatController@chats');
Route::post('/group/{group}/read', 'GroupChatController@read');
Route::post('/readBy/{id}', 'GroupChatController@readBy');// {id} logic với $id bên controller
Route::post('/group/{group}/clear', 'GroupChatController@clear');
Route::post('/group/{group}/delete', 'GroupChatController@delete');
Route::post('/user/{user}/notifications', 'NotificationController@read');
Route::post('/user/{user}/count', 'NotificationController@count');
Route::post('/user/{user}/update', 'NotificationController@update');
Route::post('/group/{group}/user/{user}/leave', 'GroupChatController@leave');
Route::post('/group/{group}/user/{user}/others', 'GroupChatController@getOtherUsers');//get friends but not group's members
Route::post('/group/{group}/add', 'GroupChatController@addMembers');
