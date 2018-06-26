<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    //Regions & Districts
    Route::resource('district', 'DistrictController');
    Route::resource('regions', 'RegionsController')->except(['show']);

    //Survey Groups & Respondents
    Route::resource('groups', 'GroupsController');
    Route::resource('respondents', 'RespondentsController');

    //Surveys & Questions
    Route::resource('surveys', 'SurveyController');
    Route::resource('surveys.questions', 'QuestionController');
    Route::get('/questions/{question}/delete', 'QuestionController@destroy');
    Route::resource('outbox', 'OutboxController');
});
