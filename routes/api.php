<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/////////////////////////////////////// AUTH ////////////////////////////////////////////////////
Route::group(['prefix' => 'auth'], function() {
	Route::post('/login', 'Api\AuthController@login');
	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('/logout', 'Api\AuthController@logout');
	});
});

/////////////////////////////////////// GET DATA ////////////////////////////////////////////////////
Route::group(['middleware' => 'auth:api'], function() {
	Route::post('/{code}/dni/{dni}', 'Api\ApiController@dni');
	Route::post('/{code}/ruc/{ruc}', 'Api\ApiController@ruc');
});