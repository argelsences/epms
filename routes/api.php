<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users', 'UserController@list');
    Route::get('/departments', 'DepartmentController@list');
    Route::post('/users/upsert', 'UserController@upsert');
    //Route::delete('/categories/{category}', 'CategoryController@destroy');
    /////Route::middleware('can:delete,category')->delete('/categories/{category}', 'CategoryController@destroy');
    //Route::post('/menu-items/add', 'MenuItemController@store');
});
