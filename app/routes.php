<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Home ---
Route::get('/', 'HomeController@showWelcome');

Route::get('tipos', 'HomeController@getTipos');

Route::get('estados', 'HomeController@getEstados');


Route::post('models', 'HomeController@getModels');

Route::post('marcas', 'HomeController@getMarcas');

Route::post('submarcas', 'HomeController@getSubMarcas');

Route::post('descripcion', 'HomeController@getDescription');


Route::post('municipios', 'HomeController@getMunicipios');

Route::post('cp', 'HomeController@getCP');

Route::post('contacto', 'HomeController@contacto');

Route::post('cotizar', 'HomeController@cotizar');

//
// Cotizar --

Route::get('pagar', 'QuoteController@procesarPago');

Route::get('pago-banco', 'QuoteController@cargoBanco');

Route::post('pago-tarjeta', 'QuoteController@cargoTarjeta');

Route::get('pago-tienda', 'QuoteController@cargoTienda');

Route::post('cambiar-formato', 'HomeController@cambiarFormato');

Route::post('proceder', 'QuoteController@cargarDatos');

Route::post('cargarPoliza', 'QuoteController@guardarPoliza');

//
// Comunes --
Route::get('aviso-privacidad', 'HomeController@getAviso');


// Intento de API REST.
Route::post('webhook', 'UriController@webHook');


//  Ejemplo como regresar vista
// Route::get('/', function()
// {
// 	return View::make('hello');
// });