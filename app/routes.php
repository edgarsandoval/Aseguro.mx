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
Route::get('/', 'HomeController@showWelcome');

Route::post('models', 'HomeController@getModels');

Route::post('marcas', 'HomeController@getMarcas');

Route::post('submarcas', 'HomeController@getSubMarcas');

Route::post('descripcion', 'HomeController@getDescription');

Route::post('estados', 'HomeController@getEstados');

Route::post('municipios', 'HomeController@getMunicipios');

Route::post('cp', 'HomeController@getCP');

Route::post('contacto', 'HomeController@contacto');

Route::post('cotizar', 'HomeController@cotizar');

Route::post('pagar', 'QuoteController@procesarPago');

Route::get('pago-banco', 'QuoteController@cargoBanco');

Route::post('pago-tarjeta', 'QuoteController@cargoTarjeta');

Route::get('pago-tienda', 'QuoteController@cargoTienda');

Route::get('error/{dump}', 'QuoteController@tratarError');

Route::get('aviso-privacidad', 'HomeController@getAviso');

// Intento de API REST.
Route::post('webhook', 'UriController@webHook');


//  Ejemplo como regresar vista
// Route::get('/', function()
// {
// 	return View::make('hello');
// });