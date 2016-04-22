<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>¡ Gracias por tu preferencia !</title>
    {{ HTML::style( asset('css/common.css'))}}
    {{ HTML::style( asset('css/pago-tienda.css')) }}
</head>

<body>
    <?php
        setlocale(LC_TIME, "es_ES");
    ?>

    <div class="whitepaper">
    	<div class="Header">
    	<div class="Logo_empresa">
        	<img src="{{ asset('images/comprobante/logo.png') }}" alt="Logo">
        </div>
        <div class="Logo_paynet">
        	<div>Servicio a pagar</div>
        	<img src="{{ asset('images/comprobante/paynet_logo.png') }}" alt="Logo Paynet">
        </div>
        </div>
        <div class="Data">
        	<div class="Big_Bullet" style="visibility:hidden;">
            	<span></span>
            </div>
        	<div class="col1">
            	<h3 style="color: #141942;">Fecha límite de pago</h3>
                <h4 style="color: #5D5D5D;">{{strftime("%A %d de %B de %G - ", strtotime('+ 1 day', strtotime($charge->creation_date))) . date('h:i:s A', strtotime('- 5 hour', strtotime($charge->creation_date)))}}</h4>
                <img width="300" src="{{ $charge->payment_method->barcode_url}}" alt="Código de Barras">
            	<span style="color: #5D5D5D;">{{$charge->payment_method->reference}}</span>
                <small style="color: #5D5D5D;">En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra.</small>
            
            </div>
            <div class="col2">
            	<h2>Total a pagar</h2>
                <h1>${{number_format(floatval($charge->amount), 2, '.', ',')}}</h1>
                <h2 class="S-margin">+8 pesos por comisión</h2>
            </div>
        </div>
        <div class="DT-margin"></div>
        <div class="Data">
        	<div class="Big_Bullet" style="visibility:hidden;">
            	<span></span>
            </div>
        	<div class="col1">
            	<h3 style="color: #141942">Detalles de la compra</h3>
            </div>
    	</div>
        <div class="Table-Data" >
        	<div class="table-row color1">
            	<div><h4 style="color: #141942; margin: 0;">Descripción</h4></div>
                <span><h4 style="color: #141942; margin: 0;">PÓLIZA DE COBRO aseguro.mx</h4></span>
            </div>
        	<div class="table-row color1">
            	<div><h4 style="color: #141942; margin: 0;">Fecha y hora</h4></div>
                <span><h4 style="color: #141942; margin: 0;">{{strftime("%A %d de %B de %G - ", strtotime($charge->creation_date)) . date('h:i:s A', strtotime('- 5 hour', strtotime($charge->creation_date)))}}</h4></span>
            </div>
        	<div class="table-row color1">
            	<div><h4 style="color: #141942; margin: 0;">Correo del cliente</h4></div>
                <span><h4 style="color: #141942; margin: 0;">{{$email}}</h4></span>
            </div>
        	<div class="table-row color2"  style="display:none">
            	<div>&nbsp;</div>
                <span>&nbsp;</span>
            </div>
        	<div class="table-row color1" style="display:none">
            	<div>&nbsp;</div>
                <span>&nbsp;</span>
            </div>
        </div>
        <div class="DT-margin"></div>
        <div>
            <div class="Big_Bullet" style="visibility: hidden;">
            	<span></span>
            </div>
        	<div class="col1">
            	<h3 style="color: #141942;">Como realizar el pago</h3>
                <ol style="color: #5D5D5D;">
                	<li>Acude a cualquier tienda afiliada</li>
                    <li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet</li>
                    <li>Realizar el pago en efectivo por $ {{number_format(floatval($charge->amount), 2, '.', ',')}} MXN <br>(más $8 pesos por comisión)</li>
                    <li>Conserva el ticket para cualquier aclaración</li>
                </ol>
            </div>
        	<div class="col1">
            	<h3 style="color: #141942;">Instrucciones para el cajero</h3>
                <ol style="color: #5D5D5D;">
                	<li>Ingresar al menú de Pago de Servicios</li>
                    <li>Seleccionar Paynet</li>
                    <li>Escanear el código de barras o ingresar el núm. de referencia</li>
                    <li>Ingresa la cantidad total a pagar</li>
                    <li>Cobrar al cliente el monto total más la comisión de $8 pesos</li>
                    <li>Confirmar la transacción y entregar el ticket al cliente</li>
                </ol>
            </div>    
        </div>
        
        <div class="logos-tiendas">
        	<div><img width="50" src="{{ asset('images/comprobante/7eleven.png') }}" alt="7elven"></div>
            <div class="margen2"><img width="90" src="{{ asset('images/comprobante/extra.png') }}" alt="7elven"></div>
            <div class="margen2"><img width="90" src="{{ asset('images/comprobante/farmacia_ahorro.png') }}" alt="7elven"></div>
            <div class="mg3"><img width="150" src="{{ asset('images/comprobante/benavides.png') }}" alt="7elven"></div>
            <div class="mg3"><small>¿Quieres pagar en otras tiendas? <br> visita: www.openpay.mx/tiendas</small></div>
        </div>
        <div class="Powered">
        	<img src="{{ asset('images/comprobante/powered_openpay.png') }}" alt="Powered by Openpay" width="150" style="border-bottom: 2px solid #C1482F;padding-bottom: 10px;">
        </div>
        
        
        
        
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>