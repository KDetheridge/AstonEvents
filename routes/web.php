<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

//display the home/welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');
//Display the login page
Route::get('/login', function () {
    return view('login');
})->name('login');
//Display the registration page
Route::get('/register', function () {
    return view('register');
})->name('register');
//display the event creation page
Route::get('/newEvent', function () {
    return view('newEvent');
});

/**ORGANISER ROUTES*/

//A route to validate and create a new Organiser within the database. Must have a unique email.
Route::post('/registerUser', 'App\Http\Controllers\OrganiserController@registerOrganiser');
//Route for querying the database for a match with the login information. The user is logged in if there is a match.
Route::post('/loginUser', 'App\Http\Controllers\OrganiserController@loginOrganiser')->name('loginUser');
//Route to log out a user that is logged in, and redirect to the welcome page
Route::get('/logoutUser','App\Http\Controllers\OrganiserController@logoutOrganiser')->name('logoutUser');

/**EVENT ROUTES*/

//Route for viewing all events
Route::get('/list','App\Http\Controllers\EventController@list');
Route::get('/list/{organiserID}','App\Http\Controllers\EventController@listMyEvents')->name('myEvents');
//Route for the function that validates and submits data to the database 
Route::post('/createEvent','App\Http\Controllers\EventController@createEvent')->name('createEvent');
//Route for registering interest in an event with ID "eventID"
Route::get('/registerInterest/{eventID}','App\Http\Controllers\EventController@registerInterest');
//Route for viewing an individual event's details
Route::get('/event/{eventID}','App\Http\Controllers\EventController@getEventByID')->name('event');

Route::get('/updateEvent/{eventID}','App\Http\Controllers\EventController@getUpdateEventForm');

Route::post('/updateEvent', 'App\Http\Controllers\EventController@updateEvent')->name('updateEvent');