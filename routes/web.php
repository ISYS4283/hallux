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

Route::view('/', 'welcome', ['title' => 'Hallux Productions Welcome']);

Route::name('query')->match(['get', 'post'], '/query', 'QueryController@run');

Route::resource('quizzes', 'QuizController');
