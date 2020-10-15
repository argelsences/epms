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

Route::group(['middleware' => ['auth:api']], function(){
    // users
    Route::get('/users', 'UserController@list')->name('users.list');
    Route::get('/profile', 'UserController@getProfile')->name('user.profile');
    Route::post('/users/upsert', 'UserController@upsert')->name('users.upsert');
    // roles
    Route::get('/roles', 'UserController@getAllRoles')->name('users.roles');
    // departments
    Route::get('/departments', 'DepartmentController@list')->name('departments.list');
    Route::post('/departments/upsert', 'DepartmentController@upsert')->name('departments.upsert');
    Route::post('/departments/uploadLogo', 'DepartmentController@uploadLogo')->name('departments.uploadLogo');
    // speakers
    Route::get('/speakers', 'SpeakerController@list')->name('speakers.list');
    Route::post('/speakers/upsert', 'SpeakerController@upsert')->name('speakers.upsert');
    Route::post('/speakers/uploadPhoto', 'SpeakerController@uploadPhoto')->name('speakers.uploadPhoto');
    // venues
    Route::get('/venues', 'VenueController@list')->name('venues.list');
    Route::post('/venues/upsert', 'VenueController@upsert')->name('venues.upsert');
    Route::post('/venues/uploadPhoto', 'VenueController@uploadPhoto')->name('venues.uploadPhoto');
    // countries, read only
    Route::get('/countries', 'VenueController@countries')->name('countries.list');
    // Events
    Route::get('/events', 'EventController@list')->name('events.list');
    // Templates
    Route::get('/templates', 'TemplateController@list')->name('templates.list');
    Route::post('/templates/upsert', 'TemplateController@upsert')->name('templates.upsert');
    // Settings
    Route::get('/settings', 'SettingController@list')->name('settings.list');
    Route::post('/settings/upsert', 'SettingController@upsert')->name('settings.upsert');
    Route::get('/timezones', 'SettingController@timezones')->name('settings.timezones');
    //////Route::get('/templates/screenshot/{id}', 'TemplateController@screenshot')->name('templates.screenshot');
    //Route::delete('/categories/{category}', 'CategoryController@destroy');
    /////Route::middleware('can:delete,category')->delete('/categories/{category}', 'CategoryController@destroy');
    //Route::post('/menu-items/add', 'MenuItemController@store');
});
