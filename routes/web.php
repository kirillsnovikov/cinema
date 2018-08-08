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

Route::get('/blog/genre/{slug?}', 'BlogController@genre')->name('genre');
Route::get('/blog/movie/{slug?}', 'BlogController@movie')->name('movie');
Route::get('/blog/profession/{slug?}', 'BlogController@profession')->name('profession');
Route::get('/blog/person/{slug?}', 'BlogController@person')->name('person');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@dashboard')->name('admin.index');
    Route::resource('genre', 'GenreController', ['as' => 'admin']);
    Route::resource('movie', 'MovieController', ['as' => 'admin']);
    Route::resource('profession', 'ProfessionController', ['as' => 'admin']);
    Route::resource('person', 'PersonController', ['as' => 'admin']);
    Route::resource('country', 'CountryController', ['as' => 'admin']);
    Route::get('parser', 'ParserController@index')->name('admin.parser.index');
    Route::get('parser/create', 'ParserController@create')->name('admin.parser.create');
    Route::post('parser/upload', 'ParserController@upload')->name('admin.parser.upload');
});



Route::get('/', function () {
    return view('blog.home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
