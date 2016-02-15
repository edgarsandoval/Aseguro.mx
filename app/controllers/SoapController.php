<?php

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class SoapController extends BaseController{

    public function demo()
    {
        // Add a new service to the wrapper
        SoapWrapper::add(function ($service) {
            $service
                ->name('ConsultasModelos')
                ->wsdl('http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl')
                ->trace(true)                                                   // Optional: (parameter: true/false)
                //->header()                                                      // Optional: (parameters: $namespace,$name,$data,$mustunderstand,$actor)
                //->customHeader($customHeader)                                   // Optional: (parameters: $customerHeader) Use this to add a custom SoapHeader or extended class
                //->cookie()                                                      // Optional: (parameters: $name,$value)
                //->location()                                                    // Optional: (parameter: $location)
                //->certificate()                                                 // Optional: (parameter: $certLocation)
                //->cache(WSDL_CACHE_NONE)                                        // Optional: Set the WSDL cache
                ->options(['login' => 'username', 'password' => 'password']);   // Optional: Set some extra options
        });

        $data = [
            'CurrencyFrom' => 'USD',
            'CurrencyTo'   => 'EUR',
            'RateDate'     => '2014-06-05',
            'Amount'       => '1000'
        ];

        // Using the added service
        SoapWrapper::service('ConsultasModelos', function ($service) use ($data) {
            //var_dump($service->getFunctions());
            dd($service->call('GetRelacionTipoVehiculo', [$data])->GetRelacionTipoVehiculoResult);
        });
    }


    public function demos()
    {

        $WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Catalogos.svc?wsdl";


        //Invocación al web service
        $FormasPago = new SoapClient ($WebService);


        $accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
        $token= array ( 'Token' => $accesos );
        $resultado = $FormasPago->Companias($token);
        //recibimos la respuesta dentro de un objeto

        //Mostramos el resultado de la consulta
        $resultado = \simplexml_load_string($resultado->CompaniasResult);

        print_r($resultado);
    }

    public function GetRelacionTipoVehiculo()
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

        foreach($resultado->TipoVehiculoEncontrado->TipoVehiculo as $typo) {
            echo $typo->TipoVehiculoBase;
            echo $typo->Descripcion;
        }


    }

    public function GetRelacionModelos()
    {
        $WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/ConsultasModelos.svc?wsdl";


        //Invocación al web service
        $WS = new SoapClient ($WebService);


        $accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );
        $xml = "<ModeloRequest><TipoVehiculo>1</TipoVehiculo></ModeloRequest>";


        $request = array ( 'user' => $accesos , 'RequestStr' => $xml);



        $resultado = $WS->GetRelacionModelos($request);

        print_r($resultado);

    }

    public function cotizar()
    {

        $WebService="http://fgseguros.aprosistema.com/CotizadorAutos/WebServices/Externos/Operaciones.svc?wsdl";

        //Invocación al web service
        $WS = new SoapClient ($WebService);

        $accesos = array ( 'Usuario' => 'fgexterno', 'Password' => 'fgexterno2015*' );


        $xml = "<Request>
        <DatosObligatorios>
          <Vehiculo>
            <Tipo>1</Tipo>
            <Modelo>2008</Modelo>
            <ClaveInterna>8468</ClaveInterna>
          </Vehiculo>
          <Zonificacion>
            <CPCirculacion>20000</CPCirculacion>
            <CPFacturacion>20000</CPFacturacion>
          </Zonificacion>
          <Conductor>
            <Genero>H</Genero>
            <Edad>25</Edad>
          </Conductor>
        </DatosObligatorios>
        <DatosOpcionales>
          <Vigencia>
            <Inicial>02/02/2016</Inicial>
            <Final>02/02/2017</Final>
          </Vigencia>
          <FormaPago>5</FormaPago>
        </DatosOpcionales>
      </Request>";


        $request = array ( 'Token' => $accesos , 'Request' => $xml);


        $resultado = $WS->Cotiza($request);

        dd($resultado);

    }

}