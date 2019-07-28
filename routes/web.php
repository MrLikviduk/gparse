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

Route::redirect('/', '/login')->middleware('guest');

Route::group(['middleware' => ['permission:edit parser']], function () {
    Route::resource('types', 'TypeController');

    Route::get('/groups', 'GroupController@index')->name('groups.index');
    Route::post('/groups', 'GroupController@store')->name('groups.store');
    Route::delete('/groups/{group}', 'GroupController@destroy')->name('groups.destroy');
});

Route::group(['middleware' => ['permission:manage users']], function () {
    Route::get('/users-panel', 'AdminController@usersPanelIndex')->name('admin.users.index');
    Route::patch('/users-panel/add-role', 'AdminController@usersPanelAddRole')->name('admin.users.add-role');
    Route::patch('/users-panel/remove-role/{user}/{role}', 'AdminController@usersPanelRemoveRole')->name('admin.users.remove-role');
});

Route::get('/home', 'UserController@home')->name('home');

Auth::routes();
