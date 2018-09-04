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
    Route::group(['prefix' => 'parser'], function() {
        Route::get('/', 'ParserController@index')->name('admin.parser.index');
        Route::group(['prefix' => 'kinopoisk'], function() {
            Route::get('/', 'ParserController@kinopoisk')->name('admin.parser.kinopoisk.index');
            Route::get('movie', 'ParserController@createMovie')->name('admin.parser.kinopoisk.movie.create');
            Route::get('person', 'ParserController@createPerson')->name('admin.parser.kinopoisk.person.create');
            Route::post('start', 'ParserController@start')->name('admin.parser.start');
        });
        Route::group(['prefix' => 'proxy'], function() {
            Route::get('create', 'ParserController@createProxy')->name('admin.parser.proxy.create');
            Route::post('check', 'ParserController@checkProxy')->name('admin.parser.check');
        });
//        Route::group(['prefix' => 'teestore'], function() {
//            Route::get('/', 'ParserController@teestore')->name('admin.parser.teestore.index');
//            Route::get('movie', 'ParserController@createLink')->name('admin.parser.teestore.link.create');
//            Route::get('person', 'ParserController@createCard')->name('admin.parser.teestore.card.create');
//            Route::post('start', 'ParserController@start')->name('admin.parser.start');
//        });
    });
});



Route::get('/', function () {
    return view('blog.home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
