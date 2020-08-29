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

Route::get('/', 'PagesController@index');

Route::get('/books', 'BooksController@index')->middleware('auth');
Route::get('/books/create', 'BooksController@create');
Route::post('/books', 'BooksController@store');
Route::get('/books/{id}', 'BooksController@show');

Route::get('/books/{id}/edit', 'BooksController@edit');
Route::put('/books/{id}/edit', 'BooksController@update');
Route::delete('/books/{id}', 'BooksController@destroy');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
