<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});
Route::get('register', 'UserController@showFormRegister')->name('show.register');
Route::post('register', 'UserController@register')->name('register');
Route::get('login', 'UserController@showFormLogin')->name('show.login');
Route::post('login', 'UserController@login')->name('login');
Route::get('logout', 'UserController@logout')->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('todo', 'NoteController@index')->name('index');
    Route::get('add-todo', 'NoteController@create')->name('show.create');
    Route::post('add-todo', 'NoteController@store')->name('store.todo');
    Route::get('todo/{id}/detail', 'NoteDetailController@show')->name('show.note');
    Route::post('{id}/todo-add-note', 'NoteDetailController@store')->name('store.note');
    Route::get('{id}/update-todo', 'NoteController@edit')->name('edit.todo');
    Route::post('{id}/update-todo', 'NoteController@update')->name('update.todo');
    Route::get('delete-todo/{id}', 'NoteController@destroy')->name('delete.todo');
    Route::get('search', 'NoteController@search')->name('search.todo');
    Route::get('status/update-todo/{id?}', 'NoteController@updateStatus')->name('todo.change_status');
    Route::get('log-activity', 'LogActivity@getLog')->name('log');
    Route::get('recent', 'NoteController@recent')->name('recent');
    Route::get('clear-cache', 'NoteController@clearCache')->name('clear');
});

