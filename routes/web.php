<?php

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/call_back_path','IvrController@call_back_path');

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
    Route::get('/dt_surveys','SurveyController@fetchSurveys');
    Route::resource('surveys', 'SurveyController');
    //surveys template
    Route::get('template/{survey_id}','SurveyController@template');
    //exportPdf
    Route::get('/exportPDF/{id}','SurveyController@exportPDF');
    
    Route::get('/dt_sms_actions','SMSController@fetchSMSActions');
    Route::resource('sms-actions', 'SMSController');
    Route::resource('answer-weights', 'AnswerWeightsController');
    Route::resource('surveys.questions', 'QuestionController');
    Route::get('/questions/{question}/delete', 'QuestionController@destroy');
    Route::get('load_questionier/{survey_id}', 'SurveyController@load_questionier')->name('load_questionier');
    Route::resource('outbox', 'OutboxController');

    Route::get('dt_categories', 'CategoryController@fetchCategories');
    Route::resource('category', 'CategoryController');
    Route::resource('category_message', 'CategoryMessageController');
    //notification
    Route::resource('/notify','NotificationController');
    Route::get('/notification','NotificationController@sendNotification');
    Route::get('/survey_sender','SurveyController@survey_sender');
    Route::post('/reuse_survey','SurveyController@reuse_survey');
    
    Route::resource('/ivr','IvrController');
});