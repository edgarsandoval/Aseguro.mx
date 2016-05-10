<?php

class UriController extends BaseController {

	public function webHook()
	{
		$json = file_get_contents('php://input');
		$action = json_decode($json);


		switch ($action->type)
		{
			case 'verification':
				$codigo = $action->verification_code;
				//mail("edgar@sitiorandom", "Codigo de verificación Openpay", $codigo);
				file_put_contents('codigo.txt', $codigo);
				header("HTTP/1.1 200 OK");
				break;

			case 'charge.succeeded':
				$order = $action->transaction->order_id;
				$emision = DB::table('emisiones')->where('order_id', $order)->first();

				$WebService = 'http://fgseguros.aprosistema.com/QA/CotizadorAutos/WebServices/Externos/Operaciones.svc?wsdl';

				//Invocación al web service
				$WS = new SoapClient ($WebService);

				$accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*');
				$xml = '<Request>
							<Cotizacion_Id>'. $emision->cotizacion_id . '</Cotizacion_Id>
							<Vigencia>
								<Inicial>' . $emision->vigencia_inicial . '</Inicial>
								<Final>' . $emision->vigencia_final . '</Final>
							</Vigencia>
							<No_Expediente>' . $emision->cotizacion_id . '</No_Expediente>
							<Contratante>
								<Personalidad>' . $emision->personalidad . '</Personalidad>
								<RFC>' . $emision->rfc . '</RFC>
								<Pol_Exp>' . $emision->pol_exp . '</Pol_Exp>
								<Persona_Fisica>
									<Primer_Nombre>' . $emision->primer_nombre  . '</Primer_Nombre>
									<Segundo_Nombre>
									</Segundo_Nombre>
									<Apellido_Paterno>' . $emision->apellido_paterno . '</Apellido_Paterno>
									<Apellido_Materno>' . $emision->apellido_materno . '</Apellido_Materno>
									<Genero>' . $emision->genero . '</Genero>
									<Edo_Civil>' . $emision->edo_civil. '</Edo_Civil>
									<CURP>' . ($emision->curp ? : '') . '</CURP>
									<Ocupacion>' . $emision->ocupacion . '</Ocupacion>
								</Persona_Fisica>
								<Datos_Origen>
									<Fecha_Nacimiento>' . $emision->fecha_nacimiento . '</Fecha_Nacimiento>
									<Pais_Nacimiento>1</Pais_Nacimiento>
								</Datos_Origen>
								<Datos_Domicilio>
									<Calle>' . $emision->calle . '</Calle>
									<No_Exterior>' . $emision->no_exterior . '</No_Exterior>
									<No_Interior>' . ($emision->no_interior ? : ''). '</No_Interior>
									<Colonia>' . $emision->colonia . '</Colonia>
									<Cod_Postal>' . $emision->cod_postal . '</Cod_Postal>
									<Pais>1</Pais>
									<Estado>' . $emision->estado . '</Estado>
									<Municipio>' . $emision->municipio . '</Municipio>
								</Datos_Domicilio>
								<Datos_Contacto>
									<Tel_Particular>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Particular>
									<Tel_Trabajo>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Trabajo>
									<Tel_Movil>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->movil_area . '</Cod_Area>
										<Numero>' . $emision->movil_numero . '</Numero>
									</Tel_Movil>
									<Email>' . $emision->email . '</Email>
								</Datos_Contacto>
							</Contratante>
							<Propietario>
								<Personalidad>' . $emision->personalidad . '</Personalidad>
								<RFC>' . $emision->rfc . '</RFC>
								<Pol_Exp>' . $emision->pol_exp . '</Pol_Exp>
								<Persona_Fisica>
									<Primer_Nombre>' . $emision->primer_nombre  . '</Primer_Nombre>
									<Segundo_Nombre>
									</Segundo_Nombre>
									<Apellido_Paterno>' . $emision->apellido_paterno . '</Apellido_Paterno>
									<Apellido_Materno>' . $emision->apellido_materno . '</Apellido_Materno>
									<Genero>' . $emision->genero . '</Genero>
									<Edo_Civil>' . $emision->edo_civil. '</Edo_Civil>
									<CURP>' . ($emision->curp ? : '') . '</CURP>
									<Ocupacion>' . $emision->ocupacion . '</Ocupacion>
								</Persona_Fisica>
								<Datos_Origen>
									<Fecha_Nacimiento>' . $emision->fecha_nacimiento . '</Fecha_Nacimiento>
									<Pais_Nacimiento>1</Pais_Nacimiento>
								</Datos_Origen>
								<Datos_Domicilio>
									<Calle>' . $emision->calle . '</Calle>
									<No_Exterior>' . $emision->no_exterior . '</No_Exterior>
									<No_Interior>' . ($emision->no_interior ? : ''). '</No_Interior>
									<Colonia>' . $emision->colonia . '</Colonia>
									<Cod_Postal>' . $emision->cod_postal . '</Cod_Postal>
									<Pais>1</Pais>
									<Estado>' . $emision->estado . '</Estado>
									<Municipio>' . $emision->municipio . '</Municipio>
								</Datos_Domicilio>
								<Datos_Contacto>
									<Tel_Particular>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Particular>
									<Tel_Trabajo>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Trabajo>
									<Tel_Movil>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->movil_area . '</Cod_Area>
										<Numero>' . $emision->movil_numero . '</Numero>
									</Tel_Movil>
									<Email>' . $emision->email . '</Email>
								</Datos_Contacto>
							</Propietario>
							<Conductor>
								<Personalidad>' . $emision->personalidad . '</Personalidad>
								<RFC>' . $emision->rfc . '</RFC>
								<Pol_Exp>' . $emision->pol_exp . '</Pol_Exp>
								<Persona_Fisica>
									<Primer_Nombre>' . $emision->primer_nombre  . '</Primer_Nombre>
									<Segundo_Nombre>
									</Segundo_Nombre>
									<Apellido_Paterno>' . $emision->apellido_paterno . '</Apellido_Paterno>
									<Apellido_Materno>' . $emision->apellido_materno . '</Apellido_Materno>
									<Genero>' . $emision->genero . '</Genero>
									<Edo_Civil>' . $emision->edo_civil. '</Edo_Civil>
									<CURP>' . ($emision->curp ? : '') . '</CURP>
									<Ocupacion>' . $emision->ocupacion . '</Ocupacion>
								</Persona_Fisica>
								<Datos_Origen>
									<Fecha_Nacimiento>' . $emision->fecha_nacimiento . '</Fecha_Nacimiento>
									<Pais_Nacimiento>1</Pais_Nacimiento>
								</Datos_Origen>
								<Datos_Domicilio>
									<Calle>' . $emision->calle . '</Calle>
									<No_Exterior>' . $emision->no_exterior . '</No_Exterior>
									<No_Interior>' . ($emision->no_interior ? : ''). '</No_Interior>
									<Colonia>' . $emision->colonia . '</Colonia>
									<Cod_Postal>' . $emision->cod_postal . '</Cod_Postal>
									<Pais>1</Pais>
									<Estado>' . $emision->estado . '</Estado>
									<Municipio>' . $emision->municipio . '</Municipio>
								</Datos_Domicilio>
								<Datos_Contacto>
									<Tel_Particular>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Particular>
									<Tel_Trabajo>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->particular_area . '</Cod_Area>
										<Numero>' . $emision->particular_numero . '</Numero>
									</Tel_Trabajo>
									<Tel_Movil>
										<Cod_Pais>52</Cod_Pais>
										<Cod_Area>' . $emision->movil_area . '</Cod_Area>
										<Numero>' . $emision->movil_numero . '</Numero>
									</Tel_Movil>
									<Email>' . $emision->email . '</Email>
								</Datos_Contacto>
							</Conductor>
							<Vehiculo>
								<Tipo>' . $emision->tipo . '</Tipo>
								<Modelo>' . $emision->modelo . '</Modelo>
								<ClaveInterna>' . $emision->clave_interna . '</ClaveInterna>
								<No_Serie>' . $emision->no_serie . '</No_Serie>
								<No_Motor>' . $emision->no_motor . '</No_Motor>
								<Placas>' . ($emision->placas ? : '') . '</Placas>
								<REPUVE>' . ($emision->REPUVE ? : '') . '</REPUVE>
								<Ubicacion>' . $emision->estado . '</Ubicacion>
							</Vehiculo>
						</Request>';


				$request = array ( 'Token' => $accesos , 'Request' => $xml);

				$poliza = $WS->Emite($request);
				$poliza = \simplexml_load_string($poliza->EmiteResult);

				$toEmail = 'edgar@sitiorandom.com';

				$data = array('url' => $poliza->Poliza_URL);

				Mail::send('emails.poliza', $data , function($message) use ($toEmail, $poliza)
				{
					$message->from('no-reply@aseguro.mx', 'Emisión de poliza');
					$message->to($toEmail, $name = null);
					$message->subject('¡Gracias por confiar en Aseguro! - PÓLIZA DE SEGURO');
					$message->attach($poliza->Poliza_URL, 
						array(
							'mime' => 'application/pdf'
							));
				});

				header("HTTP/1.1 200 OK");

				break;
			
			default:
				# code...
				break;
		}
	}
}