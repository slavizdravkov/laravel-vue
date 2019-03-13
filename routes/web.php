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

    Route::get('show/{id}', [
        'uses' => 'QuestionsController@show',
        'as' => 'questions.show'
    ]);

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

    Route::get('{slug}', [
        'uses' => 'QuestionsController@show',
        'as' => 'questions.show'
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
