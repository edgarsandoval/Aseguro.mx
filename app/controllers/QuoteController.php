<?php

//require(dirname(__FILE__) . '/Openpay/Openpay.php');

class QuoteController extends BaseController {

	public function procesarPago()
	{
		switch (intval(Input::get('opcion')))
		{
			case 1:
				return Redirect::action('QuoteController@cargoBanco', Input::all());
				break;

			case 2:
				return View::make('procesar-tarjeta', Input::all());
				break;

			case 3:
				return Redirect::action('QuoteController@cargoTienda', Input::all());
				break;
			case 4:
				return Redirect::action('QuoteController@cargoPaypal', Input::all());
				break;
		}
	}

	public function cargoBanco()
	{
		$openpay = Openpay::getInstance('m7bm553khn5nbyn5fg75', 'sk_80f1cd0745f24af8ae46929496601fa5'); // Variable de identificación.

		$cliente = array(
			'name' => Input::get('nombre'),
			'last_name' => Input::get('apellido'),
			'phone' => (Input::get('telefono') ? : null),
			'email' => Input::get('email')
			);

		$chargeData = array(
		    'method' => 'bank_account',
		    'amount' => (float) Input::get('monto'),
		    'description' => 'Cargo con banco',
		    'order_id' => 'oid-' . Input::get('id'),
		    'customer' => $cliente
			);

		$charge = $openpay->charges->create($chargeData);

		return View::make('pago-bancario', array('charge' => $charge, 'email' => Input::get('email')));
	}


	public function cargoTarjeta()
	{

		$openpay = Openpay::getInstance('m7bm553khn5nbyn5fg75', 'sk_80f1cd0745f24af8ae46929496601fa5'); // Variable de identificación.

		$cliente = array(
			'name' => Input::get('nombre'),
			'last_name' => Input::get('apellido'),
			'phone' => (Input::get('telefono') ? : null),
			'email' => Input::get('email')
			);

		$chargeData = array(
		    'method' => 'card',
		    'source_id' => Input::get('token_id'),
		    'amount' => (float) Input::get('monto'),
		    'description' => 'Pago póliza seguro',
		    'device_session_id' => Input::get('deviceIdHiddenFieldName'),
		    'customer' => $cliente
		    );

		try 
		{
			$charge = $openpay->charges->create($chargeData);
		}
		catch(Exception $e)
		{
			$mensaje = "Hubo un error con la tarjeta, revísala o intenta más tarde";
			return Redirect::action('HomeController@showWelcome', array('message' => $mensaje));
		}


		$mensaje = 'Cargo ejecutado con exito, revise su bandeja';

		return Redirect::action('HomeController@showWelcome', array('message' => $mensaje));
	}


	public function cargoTienda()
	{
		$openpay = Openpay::getInstance('m7bm553khn5nbyn5fg75', 'sk_80f1cd0745f24af8ae46929496601fa5'); // Variable de identificación.

		$cliente = array(
			'name' => Input::get('nombre'),
			'last_name' => Input::get('apellido'),
			'phone' => (Input::get('telefono') ? : null),
			'email' => Input::get('email')
			);

		$chargeData = array(
		    'method' => 'store',
		    'amount' => (float) Input::get('monto'),
		    'description' => 'Cargo a tienda',
		    'customer' => $cliente
		    );

		$charge = $openpay->charges->create($chargeData);

		return View::make('pago-tienda', array('charge' => $charge, 'email' => Input::get('email')));

	}

	public function cargoPaypal()
	{
		$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		$fields = array(
			'cmd' => "_xclick",
			'business' => 'edgar@sitiorandom.com',
			'item_name' => 'Póliza aseguro.mx',
			'currency_code' => 'MXN',
			);
		$fields_string = '';

		foreach($fields as $key=>$value)
		{
			$fields_string .= $key.'='.$value.'&';
		}
		rtrim($fields_string, '&');


		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}

	public function tratarError($dump)
	{
		dd($dump);
	}

}