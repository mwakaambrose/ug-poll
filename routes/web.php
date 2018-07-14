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
    Route::get('/dt_groups', 'GroupsController@fetchGroups');
    Route::get('/dt_respondents','RespondentsController@fetchGroups');
    Route::resource('groups', 'GroupsController');
    Route::get('/dt_respondents','RespondentsController@fetchRespondents');
    Route::resource('respondents', 'RespondentsController');

    //Surveys & Questions
    Route::resource('surveys', 'SurveyController');
    Route::resource('sms-actions', 'SMSController');
    Route::resource('answer-weights', 'AnswerWeightsController');
    Route::resource('surveys.questions', 'QuestionController');
    Route::get('/questions/{question}/delete', 'QuestionController@destroy');
    Route::get('load_questionier/{survey_id}', 'SurveyController@load_questionier')->name('load_questionier');
    Route::resource('outbox', 'OutboxController');
    Route::resource('category', 'CategoryController');
    Route::resource('category_message', 'CategoryMessageController');
});