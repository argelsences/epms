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
Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'd'], function () {
	Route::get('/{department_slug}', 'DepartmentController@homepage')->name('department.homepage');
	Route::get('/{department_slug}/events/{event_id}', 'EventController@display_event')->name('event.display');
	/////Route::post('/{department_slug}/events/{event_id}/checkout', 'TicketController@checkout')->name('tickets.checkout');
});

Route::get('/booking/{reference}', 'TicketController@booking_details')->name('booking.details');
Route::get('/booking/{reference}/tickets','TicketController@booking_tickets')->name('booking.tickets');

Auth::routes(['verify' => true]);

/////Route::get('{name}', 'HomeController@department')->name('department.homepage');

/*Route::prefix('web-admin')->group(function(){
    Auth::routes();
});*/

/////Route::prefix('web-admin')->middleware('auth')->group(function(){
Route::group(['prefix' => 'web-admin','middleware' => ['auth']], function () {	
	Route::get('/', 'WebAdminController@dashboard')->name('admin.dashboard');
	// later remove this
	Route::resource('/user', 'UserController', ['except' => ['show']]);
	Route::get('/profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('/profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('/profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	
});

Route::group(['prefix' => 'web-admin','middleware' => ['role:Contributor|Author|Super Administrator|Administrator']], function () {
	// export bookings
	Route::get('/bookings/export-to-csv', 'BookController@exportToCSV')->name('bookings.export-to-csv');
	// export attendees
	Route::get('/attendees/export-to-csv', 'AttendeeController@exportToCSV')->name('attendees.export-to-csv');
	Route::get('/attendees/print/{event}', 'AttendeeController@displayPrintableAttendees')->name('attendees.print');
});

Route::group(['prefix' => 'web-admin','middleware' => ['role:Super Administrator|Administrator']], function () {
	Route::get('/users', 'UserController@index')->name('users.index');
	Route::get('/departments', 'DepartmentController@index')->name('departments.index');
	Route::get('/speakers', 'SpeakerController@index')->name('speakers.index');
	Route::get('/venues', 'VenueController@index')->name('venues.index');
	Route::get('/events', 'EventController@index')->name('events.index');
	Route::get('/templates', 'TemplateController@index')->name('templates.index');

	Route::get('/template/template-choice', 'TemplateController@template_choice')->name('templates.template_choice');
	Route::get('/templates/by-upload', 'TemplateController@by_upload')->name('templates.by_upload');
	Route::get('/templates/by-code', 'TemplateController@by_code')->name('templates.by_code');
	Route::get('/templates/by-canvas', 'TemplateController@by_canvas')->name('templates.by_canvas');
	Route::get('/templates/screenshot/{id}', 'TemplateController@screenshot')->name('templates.screenshot');
	
	Route::get('/settings', 'SettingController@edit')->name('settings.edit');
	Route::get('/posters', 'PosterController@index')->name('posters.index');
});

/////Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

/*
Route::group(['middleware' => 'auth'], function () {
	
});
*/

/*
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
*/

/*
Route::namespace('Admin')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
});
*/
/*
Route::get('{any}', function () {
    return view('homepage');
})->where('any','.*');
*/

/*
 * Public department page routes
*/

// remove on production
/*
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
*/