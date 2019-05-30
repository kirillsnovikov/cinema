<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api'], function () {
//    Route::resource('persons', 'PersonController', ['except' => ['create', 'edit']]);
//});

Route::apiResource('persons', 'Api\V1\PersonController');
Route::apiResource('movies', 'Api\V1\MovieController');
Route::get('search/movies', 'Api\V1\SearchController@search')->name('search.movies');

//Route::get('/personss', function () {
//    return response(['Product 1', 'Product 2', 'Product 3'],200);
//});
