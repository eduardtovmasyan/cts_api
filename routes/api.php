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
Route::group(['middleware' => ['auth:api']], function() {
    Route::resource('admin', 'AdminController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::resource('subject', 'SubjectController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);
    
    Route::resource('topic', 'TopicController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::resource('group', 'GroupController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);
    
    Route::resource('one-choice-question', 'OneChoiceQuestionController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);
    
    Route::resource('multiple-choice-question', 'MultipleChoiceQuestionController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::resource('boolean-question', 'BooleanQuestionController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::resource('testee', 'TesteeController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::resource('short-answer-question', 'ShortAnswerQuestionController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);
    
    Route::resource('test', 'TestController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy']
    ]);

    Route::get('test/{id}/result', 'TestResultController@GettestResultById');

    Route::get('testee/{id}/result', 'TestResultController@getTesteeResult');
    
    Route::get('group/{id}/result', 'TestResultController@getGroupResult');
   
    Route::post('testing', 'TestingController@submitResult');
});
