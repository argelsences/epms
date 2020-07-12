<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function(){
    Route::get('/web-admin', 'AdminController@dashboard')->name('admin.dashboard');
});

Route::group(['middleware' => ['role:super-administrator|administrator']], function () {
    Route::get('/web-admin/users', 'UserController@index')->name('user.index');
	Route::get('/web-admin/users/create', 'UserController@create')->name('user.create');
	Route::post('/web-admin/users/store', 'UserController@store')->name('user.store');
	Route::delete('/web-admin/users/{user}', 'UserController@destroy')->name('user.destroy');
	Route::get('/web-admin/users/{user}/edit', 'UserController@edit')->name('user.edit');
	Route::put('/web-admin/users/{user}', 'UserController@update')->name('user.update');
});