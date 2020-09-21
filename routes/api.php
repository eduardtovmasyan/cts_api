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

    Route::group(['middleware' => ['is_admin']], function(){

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

        Route::group(['middleware' => ['is_testee']], function() {
            
            Route::resource('result', 'ResultController', [
                'only' => ['store', 'show']
            ]);

            Route::get('test/{testId}/results', 'TestResultController@index');
            Route::get('group/{groupId}/results', 'GroupResultController@index');
            Route::get('testee/{userId}/results', 'TesteeResultController@index');
            Route::get('result/{resultId}/answers', 'ResultAnswerController@index');
        });
    });
});
