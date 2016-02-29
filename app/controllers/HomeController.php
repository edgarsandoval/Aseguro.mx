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

		unset($_GET);

		//return view('index', ['tipos' => $tipos]);
		return View::make('index', array('tipos' => $tipos, 'estados' => $estados, 'mensaje' => (Input::get('message') ? : null)));
		//return View::make('hello');
	}

	public function contacto()
	{
		$mensaje = null;

		$data = array(
			'name' => Input::get('contact-name'),
			'email' => Input::get('contact-mail'),
			'msg' => Input::get('contact-message')
		);

		$fromEmail = 'contacto@aseguro.mx';
		$fromName = 'Administrador';

		Mail::send('emails.contacto', $data, function($message) use ($fromName , $fromEmail)
		{
			$message->to($fromEmail, $fromName);
			$message->from($fromEmail, $fromName);
			$message->subject('Nuevo email de contacto');

		});

		$mensaje = 'Su correo ha sido enviado con éxito, revise su bandeja. :)';
		
		return Redirect::action('HomeController@showWelcome', array('message' => $mensaje));
	}

	public function loadModels()
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

		foreach($resultado->ModeloEncontrado->ModeloAnio as $modelo) {
			array_push($modelos,$modelo);
		}

		return json_encode($modelos);
	}

	public function loadMarcas()
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

	public function loadSubMarcas()
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

	public function loadDescription()
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


	public function loadMunicipios()
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

	public function loadCP()
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

	public function cotizar()
	{
		$WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Operaciones.svc?wsdl";

		$WebServiceAutos = "http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Catalogos.svc?wsdl";

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );

		// Catalogo de autosde Autos

		$WSA = new SoapClient($WebServiceAutos);

		$requestAutos = array( 'Token' => $accesos);

		$resultadoAutos = $WSA->Companias($requestAutos);

		$resultadoAutos = \simplexml_load_string($resultadoAutos->CompaniasResult);


		//Invocación al web service
		$WS = new SoapClient ($WebService);

		$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );


		$xml = "<Request><DatosObligatorios><Vehiculo><Tipo>".Input::get('vehicle-type')."</Tipo><Modelo>".Input::get('model')."</Modelo><ClaveInterna>".Input::get('description')."</ClaveInterna></Vehiculo><Zonificacion><CPCirculacion>".Input::get('cp')."</CPCirculacion><CPFacturacion>".Input::get('cp')."</CPFacturacion></Zonificacion><Conductor><Genero>".Input::get('user-gender')."</Genero><Edad>".Input::get('user-age')."</Edad></Conductor></DatosObligatorios></Request>";


		$request = array ( 'Token' => $accesos , 'Request' => $xml);


		$resultado = $WS->Cotiza($request);

		$resultado = \simplexml_load_string($resultado->CotizaResult);


        $paquete = array('2' => 'Amplia', '4' => 'Limitada', '5' => 'RC', '3' => 'Limitada Plus', '1' => 'Super Amplia');

        $cliente = array('nombre' => Input::get('user-name'), 'apellido' => Input::get('user-lastname'), 'telefono' => Input::get('user-phone'), 'email' => Input::get('user-email'));

		return View::make('quote', array('resultado' => $resultado, 'nombre' => Input::get('user-name'), 'marca' => Input::get('marca'), 'submarca' => Input::get('sub-marca'), 'modelo' => Input::get('model'), 'companias' => $resultadoAutos->Companias, 'paquete' => $paquete, 'cliente' => $cliente));

		//return json_encode($resultado);
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
