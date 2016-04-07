	<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{

		// Pruebas :) 

		/*$url = 'http://localhost:8888/aseguro.mx/public/webhook';
		$object = '{
		    "type" : "charge.succeeded",
		    "event_date" : "2013-11-22T15:09:38-06:00",
		    "transaction" : {
		        "amount" : 2000.0,
		        "authorization" : "801585",
		        "method" : "card",
		        "operation_type" : "in",
		        "transaction_type" : "charge",
		        "card" : {
		            "type" : "debit",
		            "brand" : "mastercard",
		            "address" : {
		               "line1" : "Calle #1 Interior #2",
		               "line2" : null,
		               "line3" : null,
		               "state" : "Queretaro",
		               "city" : "Queretaro",
		               "postal_code" : "76040",
		               "country_code" : "MX"
		            },
		            "card_number" : "1881",
		            "holder_name" : "Card Holder",
		            "expiration_month" : "10",
		            "expiration_year" : "14",
		            "allows_charges" : true,
		            "allows_payouts" : true,
		            "creation_date" : "2013-11-22T15:09:32-06:00",
		            "bank_name" : "BBVA BANCOMER",
		            "bank_code" : "012"
		        },
		        "status" : "completed",
		        "id" : "tlxcm4vprtz74qoenuay",
		        "creation_date" : "2013-11-22T15:09:33-06:00",
		        "description" : "Description",
		        "error_message" : null,
		        "order_id" : "oid_14235"
		    }
		}';
		$fields = array(
			'object' => $object,
		);

		$fields_string = "";

		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		die();

		// Fin de pruebas :) */

		//dd(DB::table('prueba')->get());

		$mensaje = Session::get('message', null);

		$tipos = $this->getTipos();
		$estados = $this->getEstados();

		return View::make('index', array('tipos' => $tipos, 'estados' => $estados, 'mensaje' => $mensaje));
	}

	public function contacto()
	{
		$mensaje = null;

		$data = array(
			'name' => Input::get('contact-name'),
			'email' => Input::get('contact-mail'),
			'msg' => Input::get('contact-message')
		);

		$toEmail = 'contacto@aseguro.mx';

		try
		{
			Mail::send('emails.contacto', $data, function($message) use ($toEmail)
			{
				$message->from('no-reply@aseguro.mx', 'Formulario de Contacto');
				$message->to($toEmail, $name = null);
				$message->subject('Nuevo email de contacto');
			});

			$mensaje = 'Su correo ha sido enviado con éxito, espere su respuesta. :)';
			return Redirect::to('/')->with('message', $mensaje);
		}
		catch (Exception $e)
		{
			$mensaje = 'Hubo un error en el servidor, intentelo más tarde';
			return Redirect::to('/')->with('message', $mensaje);
			
		}
	}

	public function getTipos()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";

		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$token = array ( 'Token' => $accesos );
		$resultado = $WS->GetRelacionTipoVehiculo($token);
		//recibimos la respuesta dentro de un objeto

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionTipoVehiculoResult);
		$tipos = array();

		foreach($resultado->TipoVehiculoEncontrado->TipoVehiculo as $typo) {
			//echo $typo->TipoVehiculoBase;
			//echo $typo->Descripcion;
			array_push($tipos,$typo);
		}

		return $tipos;
	}

	public function getEstados()
	{

		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Zonificacion.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<EstadosRequest><Pais>MEX</Pais></EstadosRequest>";


		$request = array ( 'user' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionEstado($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionEstadoResult);
		$estados = array();

		//dd($resultado);

		foreach($resultado->EstadosEncontrados->Estado as $estado) {
			array_push($estados,$estado);
		}
	}

	public function getModels()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<ModeloRequest><TipoVehiculo>".Input::get('tipo')."</TipoVehiculo></ModeloRequest>";


		$request = array ( 'user' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionModelos($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionModelosResult);
		$modelos = array();

		//dd($resultado);

		foreach($resultado->ModeloEncontrado->ModeloAnio as $modelo){
			array_push($modelos,$modelo);
		}

		return json_encode($modelos);
	}

	public function getMarcas()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<MarcaRequest><Modelo>".Input::get('modelo')."</Modelo><TipoVehiculoBase>".Input::get('tipo')."</TipoVehiculoBase></MarcaRequest>";


		$request = array ( 'user' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionMarcas($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionMarcasResult);
		$marcas = array();

		//dd($resultado);

		foreach($resultado->MarcaEncontrada->Marca as $marca) {
			array_push($marcas,$marca);
		}

		return json_encode($marcas);
	}

	public function getSubMarcas()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<SubMarcaRequest><Modelo>".Input::get('modelo')."</Modelo><IdMarca>".Input::get('marca')."</IdMarca><TipoVehiculoBase>".Input::get('tipo')."</TipoVehiculoBase></SubMarcaRequest>";


		$request = array ( 'user' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionSubMarcas($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionSubMarcasResult);
		$submarcas = array();

		//dd($resultado);

		foreach($resultado->SubMarcaEncontrada->SubMarca as $submarca) {
			array_push($submarcas,$submarca);
		}

		return json_encode($submarcas);
	}

	public function getDescription()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<DescripcionRequest><Modelo>".Input::get('modelo')."</Modelo><IdProductorSubGrupo>".Input::get('submarca')."</IdProductorSubGrupo><TipoVehiculoBase>".Input::get('tipo')."</TipoVehiculoBase><ClaveInterna>".Input::get('marca')."</ClaveInterna></DescripcionRequest>";


		$request = array ( 'user' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionDescripciones($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionDescripcionesResult);
		$descriptions = array();

		//dd($resultado);

		foreach($resultado->DescripcionEncontrada->Descripcion as $description) {
			array_push($descriptions,$description);
		}

		return json_encode($descriptions);
	}


	public function getMunicipios()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Zonificacion.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<MunicipioRequest><Estado>".Input::get('estado')."</Estado></MunicipioRequest>";


		$request = array ( 'use' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionMunicipio($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionMunicipioResult);
		$municipios = array();

		//dd($resultado);

		foreach($resultado->MunicipioEncontrado->Municipio as $municipio) {
			array_push($municipios,$municipio);
		}


		return json_encode($municipios);
	}

	public function getCP()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Zonificacion.svc?wsdl";


		//Invocación al web service
		$WS = new SoapClient ($WebService);


		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "<CPRequest><Municipio>".Input::get('municipio')."</Municipio></CPRequest>";


		$request = array ( 'use' => $accesos , 'RequestStr' => $xml);



		$resultado = $WS->GetRelacionCP($request);

		//Mostramos el resultado de la consulta
		$resultado = \simplexml_load_string($resultado->GetRelacionCPResult);
		$cps = array();

		//dd($resultado);

		foreach($resultado->CPEncontrado->CodigoPostal as $cp) 
		{
			array_push($cps,$cp);
		}


		return json_encode($cps);
	}

	public function getCompanias()
	{

		$WebServiceAutos = "http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Catalogos.svc?wsdl";

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );

		$WS = new SoapClient($WebServiceAutos);

		$request = array( 'Token' => $accesos);

		$companias = $WS->Companias($request);

		$companias = \simplexml_load_string($companias->CompaniasResult);

		return $companias->Companias;
	}

	public function cambiarFormato()
	{
		$datos = json_decode(Input::get('datos'), true);


		$WebService = "http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Operaciones.svc?wsdl";

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );

		//Invocación al web service
		$WS = new SoapClient ($WebService);

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
		$xml = "";

		$xml = "<Request>
					<DatosObligatorios>
						<Vehiculo>
							<Tipo>" . $datos['tipo'] . "</Tipo>
							<Modelo>" . $datos['modelo'] . "</Modelo>
							<ClaveInterna>" . $datos['clave-interna'] . "</ClaveInterna>
						</Vehiculo>
						<Zonificacion>
							<CPCirculacion>" . $datos['cp-circulacion'] . "</CPCirculacion>
							<CPFacturacion>" . $datos['cp-facturacion'] . "</CPFacturacion>
						</Zonificacion>
						<Conductor>
							<Genero>" . $datos['genero'] . "</Genero>
							<Edad>" . $datos['edad'] . "</Edad>
						</Conductor>
					</DatosObligatorios>
					<DatosOpcionales>
						<FormaPago>" . Input::get('forma-pago') ."</FormaPago>
					</DatosOpcionales>
				</Request>";


		$request = array ( 'Token' => $accesos , 'Request' => $xml);

		try
		{
			$cotizacion = $WS->Cotiza($request);
			$cotizacion = \simplexml_load_string($cotizacion->CotizaResult);
			return json_encode($cotizacion);
		}
		catch (Exception $e)
		{
			$mensaje = "Hubo un error en el servidor, por favor intenta de nuevo.";
			return $mensaje;
		}

	}

	public function cotizar()
	{
		/*$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Operaciones.svc?wsdl";

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );


		//Invocación al web service
		$WS = new SoapClient ($WebService);

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );


		$xml = "<Request>
					<DatosObligatorios>
						<Vehiculo>
							<Tipo>" . Input::get('vehicle-type') . "</Tipo>
							<Modelo>" . Input::get('model') . "</Modelo>
							<ClaveInterna>" . Input::get('description') . "</ClaveInterna>
						</Vehiculo>
						<Zonificacion>
							<CPCirculacion>" . Input::get('cp') . "</CPCirculacion>
							<CPFacturacion>" . Input::get('cp') . "</CPFacturacion>
						</Zonificacion>
						<Conductor>
							<Genero>" . Input::get('user-gender') . "</Genero>
							<Edad>" . Input::get('user-age') . "</Edad>
						</Conductor>
					</DatosObligatorios>
					<DatosOpcionales>
						<FormaPago>" . Input::get('payment-method') ."</FormaPago>
					</DatosOpcionales>
				</Request>";


		$request = array ( 'Token' => $accesos , 'Request' => $xml);

		try
		{
			$cotizacion = $WS->Cotiza($request);
			$cotizacion = \simplexml_load_string($cotizacion->CotizaResult);
		}
		catch (Exception $e)
		{
			$mensaje = "Hubo un error en el servidor, por favor intenta de nuevo.";
			return Redirect::to('/')->with('message', $mensaje);
			
		}*/

		$datos = array(
			'tipo' => Input::get('vehicle-type'),
			'modelo' => Input::get('model'),
			'clave-interna' => Input::get('description'),
			'cp-circulacion' => Input::get('cp'),
			'cp-facturacion' => Input::get('cp'),
			'genero' => Input::get('user-gender'),
			'edad' => Input::get('user-age'),
			'forma-pago' => Input::get('payment-method')
		);

		$cotizacion = json_decode('{"Cotizacion_Id":"1277","FechaCotizacion":"04\/04\/2016","HoraCotizacion":"12:33:18 p.m.","Vigencia":{"Inicial":"04\/04\/2016","Final":"04\/04\/2017"},"FormaPago":"4","Detalles":{"Detalle":[{"id":"16806","Paquete":"4","Compania":"105","Montos":{"PrimaNeta":"7128.94","GastosExpedicion":"600","Recargos":"598.12","Descuento":"0","IVA":"1332.33","PrimaTotal":"9659.39"}},{"id":"16807","Paquete":"2","Compania":"105","Montos":{"PrimaNeta":"20039.73","GastosExpedicion":"600","Recargos":"1681.33","Descuento":"0","IVA":"3571.37","PrimaTotal":"25892.43"}},{"id":"16808","Paquete":"2","Compania":"106","Montos":{"PrimaNeta":"35300.51","GastosExpedicion":"430","Recargos":"3177.05","Descuento":"0","IVA":"6225.21","PrimaTotal":"45132.77"}},{"id":"16809","Paquete":"4","Compania":"106","Montos":{"PrimaNeta":"16190.14","GastosExpedicion":"430","Recargos":"1457.11","Descuento":"0","IVA":"2892.36","PrimaTotal":"20969.61"}},{"id":"16810","Paquete":"4","Compania":"4","Montos":{"PrimaNeta":"5897.14","GastosExpedicion":"450","Recargos":"589.71","Descuento":"0","IVA":"1109.9","PrimaTotal":"8046.75"}},{"id":"16811","Paquete":"2","Compania":"4","Montos":{"PrimaNeta":"16579.03","GastosExpedicion":"450","Recargos":"1657.9","Descuento":"0","IVA":"2989.91","PrimaTotal":"21676.84"}},{"id":"16812","Paquete":"4","Compania":"12","Montos":{"PrimaNeta":"17382.38","GastosExpedicion":"460","Recargos":"1460.12","Descuento":"0","IVA":"3088.4","PrimaTotal":"22390.9"}},{"id":"16813","Paquete":"2","Compania":"12","Montos":{"PrimaNeta":"28342.35","GastosExpedicion":"460","Recargos":"1672.87","Descuento":"-8427.19","IVA":"3527.69","PrimaTotal":"25575.73"}}]}}');

		$companias = $this->getCompanias();

		$companiasInfo = array(
			'1' => array('Telefono' => "01 800 288 6700", 'Pagina' => "http://www.qualitas.com.mx/"),
			'3' => array('Telefono' => "01 800 322 2462", 'Pagina' => "http://www.seguroautosmapfre.com.mx/"),
			'4' => array('Telefono' => "01 800 400 9000", 'Pagina' => "https://www.gnp.com.mx/"),
			'5' => array('Telefono' => "01 800 712 2828", 'Pagina' => "http://www.abaseguros.com/Paginas/default.aspx"),
			'6' => array('Telefono' => "01 800 900 1292", 'Pagina' => "https://axa.mx/home"),
			'8' => array('Telefono' => "01 800 500 1500", 'Pagina' => "http://www.segurosbanorte.com.mx/"),
			'10' => array('Telefono' => "01 800 849 3917", 'Pagina' => "http://www.segurosatlas.com.mx/"),
			'11' => array('Telefono' => "01 800 723 4763", 'Pagina' => "https://www.afirme.com/"),
			'12' => array('Telefono' => "01 800 000 0434", 'Pagina' => "https://www.hdi.com.mx/"),
			'13' => array('Telefono' => "+52(55) 5326-8600", 'Pagina' => "http://www.segurosinteracciones.mx/"),
			'14' => array('Telefono' => "01 800 008 3693", 'Pagina' => "https://www.rsaseguros.com.mx/" ),
			'15' => array('Telefono' => "01 800 001 1300", 'Pagina' => "https://www.aig.com.mx/"),
			'16' => array('Telefono' => "01 818 048 0500", 'Pagina' => "https://www.primeroseguros.com/"),
			'17' => array('Telefono' => "01 800 004 1900", 'Pagina' => "https://www.zurich.com.mx"),
			'18' => array('Telefono' => "01 800 835 3262", 'Pagina' => "http://www.anaseguros.com.mx/"),
			'20' => array('Telefono' => "01 800 480 3100", 'Pagina' => "http://www.elpotosi.com.mx/"),
			'19' => array('Telefono' => "01 800 226 2668", 'Pagina' => "http://www.multiva.com.mx/"),
			'105' => array('Telefono' => "01 800 712 2828", 'Pagina' => "http://www.abaseguros.com/Paginas/default.aspx"),
			'106' => array('Telefono' => "01 800 900 1292", 'Pagina' => "https://axa.mx/home")

		);


        $paquete = array('2' => 'Amplia', '4' => 'Limitada', '5' => 'RC', '3' => 'Limitada Plus', '1' => 'Super Amplia');

        $cliente = array(
        	'nombre' => Input::get('user-name'),
        	'apellido' => Input::get('user-lastname'),
        	'telefono' => Input::get('user-phone'),
        	'celular' => Input::get('user-cellphone'),
        	'email' => Input::get('user-email')
        	);

       	setlocale(LC_ALL, 'es_MX.UTF-8');

		return View::make('quote', array(
				'datos' => $datos,
				'cotizacion' => $cotizacion,
				'cliente' => $cliente,
				'marca' => Input::get('marca'),
				'submarca' => Input::get('sub-marca'),
				'modelo' => Input::get('model'),
				'descripcion' => Input::get('descripcion'),
				'companias' => $companias,
				'companiasInfo' => $companiasInfo,
				'paquete' => $paquete
			));
	}

	public function getAviso()
	{

		$filename = 'AVISO DE PRIVACIDAD INTEGRAL [431580].pdf';
		$path = storage_path() . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . $filename;

		return Response::make(file_get_contents($path), 200, [
    		'Content-Type' => 'application/pdf',
    		'Content-Disposition' => 'inline; '.$filename
		]);
	}
}
