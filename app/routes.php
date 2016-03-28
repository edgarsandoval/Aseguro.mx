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

Route::get('types', 'SoapController@GetRelacionTipoVehiculo');

Route::post('models', 'HomeController@loadModels');

Route::post('marcas', 'HomeController@loadMarcas');

Route::post('submarcas', 'HomeController@loadSubMarcas');

Route::post('descripcion', 'HomeController@loadDescription');

Route::post('estados', 'HomeController@loadEstados');

Route::post('municipios', 'HomeController@loadMunicipios');

Route::post('cp', 'HomeController@loadCP');

Route::post('contacto', 'HomeController@contacto');

Route::post('cotizar', 'HomeController@cotizar');

Route::post('pagar', 'QuoteController@procesarPago');

Route::get('pago-banco', 'QuoteController@cargoBanco');

Route::post('pago-tarjeta', 'QuoteController@cargoTarjeta');

Route::get('pago-tienda', 'QuoteController@cargoTienda');

Route::get('error/{dump}', 'QuoteController@tratarError');

Route::get('aviso-privacidad', 'HomeController@getAviso');



//  Ejemplo como regresar vista
// Route::get('/', function()
// {
// 	return View::make('hello');
// });

//5204165041513890