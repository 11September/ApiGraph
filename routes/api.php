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
Route::middleware('cors')->post('register', 'UsersController@register')->name('Register');

Route::middleware('cors','token')->get('activities', 'ActivityController@index')->name('Get Activities by User');
Route::middleware('cors','token')->get('records/{activityId}', 'RecordsController@show')->name('Get Records by Activity');
Route::middleware('cors','token')->post('records', 'RecordsController@updateOrStore')->name('Records store');
