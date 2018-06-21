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
Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('surveys', 'SurveyController');
	Route::resource('respondents', 'RespondentController');
	Route::resource('region', 'RegionController');
	Route::resource('district', 'DistrictController');
	Route::resource('group', 'GroupCOntroller');
	Route::resource('respondent', 'RespondentController');
	Route::resource('questions', 'QuestionController');
	Route::resource('outbox', 'OutboxController');
});//middleware
