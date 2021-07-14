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

/////////////////////////////////////// AUTH ////////////////////////////////////////////////////

Auth::routes(['register' => false]);
Route::get('/usuarios/email', 'AdminController@emailVerifyAdmin');

/////////////////////////////////////////////// WEB ////////////////////////////////////////////////
Route::get('/', function() {
	return redirect()->route('admin');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
	/////////////////////////////////////// ADMIN ///////////////////////////////////////////////////

	// Inicio
	Route::get('/admin', 'AdminController@index')->name('admin');
	Route::get('/admin/perfil', 'AdminController@profile')->name('profile');
	Route::get('/admin/perfil/editar', 'AdminController@profileEdit')->name('profile.edit');
	Route::put('/admin/perfil/', 'AdminController@profileUpdate')->name('profile.update');

	// Usuarios
	Route::get('/admin/usuarios', 'UserController@index')->name('usuarios.index')->middleware('permission:users.index');
	Route::get('/admin/usuarios/registrar', 'UserController@create')->name('usuarios.create')->middleware('permission:users.create');
	Route::post('/admin/usuarios', 'UserController@store')->name('usuarios.store')->middleware('permission:users.create');
	Route::get('/admin/usuarios/{user:slug}', 'UserController@show')->name('usuarios.show')->middleware('permission:users.show');
	Route::get('/admin/usuarios/{user:slug}/editar', 'UserController@edit')->name('usuarios.edit')->middleware('permission:users.edit');
	Route::put('/admin/usuarios/{user:slug}', 'UserController@update')->name('usuarios.update')->middleware('permission:users.edit');
	Route::delete('/admin/usuarios/{user:slug}', 'UserController@destroy')->name('usuarios.delete')->middleware('permission:users.delete');
	Route::put('/admin/usuarios/{user:slug}/activar', 'UserController@activate')->name('usuarios.activate')->middleware('permission:users.active');
	Route::put('/admin/usuarios/{user:slug}/desactivar', 'UserController@deactivate')->name('usuarios.deactivate')->middleware('permission:users.deactive');

	// Códigos
	Route::post('/admin/codigos/{user:slug}', 'CodeController@store')->name('codigos.store')->middleware('permission:users.create');
	Route::put('/admin/codigos/{code:code}', 'CodeController@update')->name('codigos.update')->middleware('permission:codes.edit');
	Route::delete('/admin/codigos/{code:code}', 'CodeController@destroy')->name('codigos.delete')->middleware('permission:codes.delete');
	Route::put('/admin/codigos/{code:code}/activar', 'CodeController@activate')->name('codigos.activate')->middleware('permission:codes.active');
	Route::put('/admin/codigos/{code:code}/desactivar', 'CodeController@deactivate')->name('codigos.deactivate')->middleware('permission:codes.deactive');
});