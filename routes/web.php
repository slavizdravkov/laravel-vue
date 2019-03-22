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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('', [
        'uses' => 'QuestionsController@index',
        'as' => 'questions.index'
    ]);

    Route::get('{slug}', [
        'uses' => 'QuestionsController@show',
        'as' => 'questions.show'
    ]);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('create', [
            'uses' => 'QuestionsController@create',
            'as' => 'questions.create'
        ]);

        Route::post('store' ,[
            'uses' => 'QuestionsController@store',
            'as' => 'questions.store'
        ]);

        Route::get('{question}/edit', [
            'uses' => 'QuestionsController@edit',
            'as' => 'questions.edit'
        ]);

        Route::post('{question}/update', [
            'uses' => 'QuestionsController@update',
            'as' => 'questions.update'
        ]);

        Route::post('{question}/destroy', [
            'uses' => 'QuestionsController@destroy',
            'as' => 'questions.destroy'
        ]);
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/questions/{question}/answers/store', [
    'uses' => 'AnswersController@store',
    'as' => 'questions.answers.store'
]);

Route::post('/questions/{question}/answers/{answer}/update', [
    'uses' => 'AnswersController@update',
    'as' => 'questions.answers.update'
]);

Route::post('/questions/{question}/answers/{answer}/destroy', [
    'uses' => 'AnswersController@destroy',
    'as' => 'questions.answers.destroy'
]);

Route::post('/questions/{question}/answers/{answer}/edit', [
    'uses' => 'AnswersController@edit',
    'as' => 'questions.answers.edit'
]);
