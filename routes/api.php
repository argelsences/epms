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

Route::get('/departments-front-list', 'DepartmentController@front_list')->name('departments.frontList');

Route::post('/contact-us', 'EventController@contact_us')->name('events.contact_us');

Route::post('/ticket/checkout', 'TicketController@checkout')->name('tickets.checkout');


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
    Route::get('/events/upload-poster', 'EventController@uploadPoster')->name('upload-poster.list');
    // Templates
    Route::get('/templates', 'TemplateController@list')->name('templates.list');
    Route::post('/templates/upsert', 'TemplateController@upsert')->name('templates.upsert');
    // Settings
    Route::get('/settings', 'SettingController@list')->name('settings.list');
    Route::post('/settings/upsert', 'SettingController@upsert')->name('settings.upsert');
    Route::get('/timezones', 'SettingController@timezones')->name('settings.timezones');
    // Events
    Route::post('/events/upsert', 'EventController@upsert')->name('events.upsert');
    //////Route::get('/templates/screenshot/{id}', 'TemplateController@screenshot')->name('templates.screenshot');
    //Route::delete('/categories/{category}', 'CategoryController@destroy');
    /////Route::middleware('can:delete,category')->delete('/categories/{category}', 'CategoryController@destroy');
    //Route::post('/menu-items/add', 'MenuItemController@store');
    //Route::get('/tickets', 'TicketController@list')->name('tickets.list');
    Route::get('/tickets/event/{event}', 'TicketController@list')->name('tickets.list');
    Route::post('/tickets/upsert', 'TicketController@upsert')->name('tickets.upsert');
    Route::post('/tickets/pause', 'TicketController@pause')->name('tickets.pause');
    // poster
    Route::get('/posters/event/{event}', 'PosterController@list')->name('posters.list');
    Route::post('/posters/upload', 'PosterController@upload')->name('poster.upload');
    Route::delete('/poster/file/delete/{poster}', 'PosterController@deleteFile');
    Route::post('/posters/generate', 'PosterController@generate')->name('poster.generate');
    // bookings
    Route::get('/bookings/event/{event}', 'BookController@list')->name('bookings.list');
    Route::delete('/booking/delete/{book}', 'BookController@destroy');
    Route::post('/bookings/update', 'BookController@update')->name('bookings.update');
    Route::post('/bookings/resend-booking', 'TicketController@resend_booking_tickets')->name('bookings.resend-booking');
    // attendee
    Route::delete('/attendees/delete/{attendee}', 'AttendeeController@destroy');
    Route::get('/attendees/event/{event}', 'AttendeeController@list')->name('attendee.list');
    Route::post('/attendees/update', 'AttendeeController@update')->name('attendees.update');
    
});
