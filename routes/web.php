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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
