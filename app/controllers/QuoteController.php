<?php

class QuoteController extends BaseController {

	public function cargarDatos()
	{
		$request = Request::create('/estados', 'GET', array());
		$estados = Route::dispatch($request)->original;
		return View::make('completar', array(
			'nombre' => Input::get('nombre'),
			'cotizacion_id' => Input::get('cotizacion_id'),
			'pago' => Input::get('pago'),
			'cobertura' => Input::get('cobertura'),
			'formato' => Input::get('formato'),
			'descripcion' => Input::get('descripcion'),
			'estados' => $estados,
			'tipo' => Input::get('tipo'),
			'claveInterna' => Input::get('clave-interna'),
			'modelo' => Input::get('modelo'),
			'recibos' => Input::get('recibos')
			));
	}

	public function guardarPoliza()
	{

		$prefix = 'frm-';

		$data = array(
			'order_id' => 'oid-' . Input::get('id'),
			'monto' => Input::get('monto'),
			'cotizacion_id' => Input::get('id'),
			'vigencia_inicial' => date('d/m/Y'),
			'vigencia_final' => date('d/m/Y', strtotime('+1 year', strtotime( date('d-m-Y')))),
			'personalidad' => Input::get($prefix . 'persona'),
			'rfc' => Input::get($prefix . 'rfc'), 
			'pol_exp' => Input::get($prefix . 'expuesto'),
			'primer_nombre' => Input::get($prefix . 'nombre'),
			'apellido_paterno' => Input::get($prefix . 'apellidop'),
			'apellido_materno' => Input::get($prefix . 'apellidom'),
			'genero' => Input::get($prefix . 'sexo'),
			'edo_civil' => Input::get($prefix . 'edocivil'),
			'curp' => Input::get($prefix . 'curp') ? : null, 
			'ocupacion' => Input::get($prefix . 'ocupacion'),
			'fecha_nacimiento' => Input::get('user-day') . '/' . Input::get('user-month') . '/' . Input::get('user-year'),
			'calle' => Input::get($prefix . 'calle'),
			'no_exterior' => Input::get($prefix . 'noext'),
			'no_interior' => Input::get($prefix . 'noint') ? : null,
			'colonia' => Input::get($prefix . 'colonia'),
			'cod_postal' => Input::get('cp'),
			'estado' => Input::get('estados'),
			'municipio' => Input::get('municipios'),
			'particular_area' => Input::get($prefix . 'codigo-tel'),
			'particular_numero' => Input::get($prefix . 'telefono'),
			'movil_area' => Input::get($prefix . 'codigo-cel'),
			'movil_numero' => Input::get($prefix . 'celular'),
			'email' => Input::get($prefix . 'correo'),
			'tipo' => Input::get($prefix . 'tipo'),
			'modelo' => Input::get($prefix . 'modelo'),
			'clave_interna' => Input::get($prefix . 'clave-interna'),
			'no_serie' => Input::get($prefix . 'no-serie'),
			'no_motor' => Input::get($prefix . 'no-motor'),
			'placas' => Input::get($prefix . 'placas') ? : null,
			'REPUVE' => Input::get($prefix . 'repuve') ? : null
			);


		DB::table('emisiones')->insert($data);	

		return Redirect::action('QuoteController@procesarPago', array(
			'opcion' => Input::get('opcion'),
			'id' => Input::get('id'),
			'monto' => Input::get('monto'),
			'plan' => Input::get('plan'),
			'recibos' => Input::get('recibos'),
			'formato' => Input::get('formato'),
			'nombre' => $data['primer_nombre'],
			'apellido' => $data['apellido_paterno'],
			'telefono' => $data['particular_numero'],
			'email' => $data['email']
			));
	}

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
		try 
		{
			$charge = $openpay->charges->create($chargeData);
		}
		catch(Exception $e)
		{
			$mensaje = "Este pago ya se había procesado, genera una nueva cotización";
			
			return Redirect::to('/')->with('message', $mensaje);
		}
		

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
			$formato = Input::get('formato');

			switch ($formato)
			{
				case 'Mensual':
					$plazo = 1;
					break;

				case 'Trimestral':
					$plazo = 3;
					break;
				case 'Semestral':
					$plazo = 6;
					break;
			}

			$charge = $openpay->charges->create($chargeData);

			if(Input::get('plan'))
			{
				$customer = $openpay->customers->add($cliente);

				$cardData = array('token_id' => Input::get('token_id'));
				$card = $customer->cards->add($cardData);

				$data = array(
					'id_cliente' => $customer,
					'id_tarjeta' => $card,
					'device_session_id' => Input::get('deviceIdHiddenFieldName'),
					'monto' => Input::get('recibos'),
					'proximo_pago' => date('Y-m-d', strtotime('+' . $plazo . ' month', strtotime(date('Y-m-d')))),
					'pagos_restantes' => 12 - $plazo
					);

				DB::table('planes')->insert($data);
			}

		}
		catch(Exception $e)
		{
			$mensaje = "Hubo un error con la tarjeta, no se pudo hacer el cargo. <br> Revísa tu tarjeta e intenta de nuevo, si el problema persiste contáctanos. ";
			
			return Redirect::action('QuoteController@procesarPago', array(
				'opcion' => Input::get('opcion'),
				'id' => Input::get('id'),
				'monto' => Input::get('monto'),
				'plan' => Input::get('plan'),
				'recibos' => Input::get('recibos'),
				'formato' => Input::get('formato'),
				'nombre' => Input::get('primer_nombre'),
				'apellido' => Input::get('apellido_paterno'),
				'telefono' => Input::get('particular_numero'),
				'email' => Input::get('email'),
				'error' => true));
		}


		$mensaje = 'Cargo ejecutado con exito, revise su bandeja';
		
		return Redirect::to('/')->with('message', $mensaje);
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
		$order = array('amount' => Input::get('monto'), 'description' => 'Pago póliza seguro');

		$baseUrl = $this->getBaseUrl() . '/order_completion.php?orderId=$orderId';
		$payment = $this->makePaymentUsingPayPal($order['amount'], 'USD', $order['description'], "$baseUrl&success=true", "$baseUrl&success=false");
	}

	public function makePaymentUsingPayPal($total, $currency, $paymentDesc, $returnUrl, $cancelUrl)
	{
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		
		// Specify the payment amount.
		$amount = new Amount();
		$amount->setCurrency($currency);
		$amount->setTotal($total);
		
		// ###Transaction
		// A transaction defines the contract of a
		// payment - what is the payment for and who
		// is fulfilling it. Transaction is created with
		// a 'Payee' and 'Amount' types
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription($paymentDesc);
		
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl($returnUrl);
		$redirectUrls->setCancelUrl($cancelUrl);
		
		$payment = new Payment();
		$payment->setRedirectUrls($redirectUrls);
		$payment->setIntent("sale");
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
		
		$payment->create(getApiContext());
		return $payment;
	}

	public function getBaseUrl()
	{
		$protocol = 'http';
		if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
			$protocol .= 's';
		}

		$host = $_SERVER['HTTP_HOST'];
		$request = $_SERVER['PHP_SELF'];
		return dirname($protocol . '://' . $host . $request);
	}
}