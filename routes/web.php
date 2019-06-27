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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', 'LoginController@login');

Route::get('/admin/dashboard', 'DashboardController@index');

Route::get('/admin/usuarios', 'UsersController@index');
Route::get('/admin/usuarios/all', 'UsersController@getUsers');


Route::get('/logout', 'LoginController@logout');

<<<<<<< HEAD
Route::group(['middleware' => 'cors'], function () {
	//Route::prefix('api')->group(function () {

		Route::post('/api/login', 'LoginController@loginAPI');
		Route::post('/api/recibo', 'RecibosPagoController@create');
		Route::post('/api/constancia', 'ConstanciaController@create');


	//});
=======
Route::prefix('api')->group(function () {

	Route::get('/work-constancy/create', 'WorkConstancyController@create');
	Route::post('/login', 'LoginController@loginAPI');


>>>>>>> 8afae6ed4eca0ded92e92cd5c4c152a3f9d9ec41
});

