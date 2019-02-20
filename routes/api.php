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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('cors')->post('login', 'UsersController@login')->name('Login');

Route::middleware('cors','token')->get('post/{id}', 'PostsController@show')->name('Get Post');
Route::middleware('cors','token')->get('schedules/{school_id}', 'SchedulesController@index')->name('Get Schedules');
Route::middleware('cors','token')->get('nutritions/{school_id}', 'NutritionsController@index')->name('Get Nutritions');
