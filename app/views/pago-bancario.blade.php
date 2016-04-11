<!doctype html>
<html>
<head>
	{{ HTML::style( asset('css/common.css')) }}
	{{ HTML::style( asset('css/comprobante-banco.css')) }}
</head>

<body>
	<div class="margen">
		<div class="header">
			<div class="Logo-Top"><img src="{{ asset('images/comprobante/logo.png')}}" alt="Logo"></div>
		</div>
		<div class="Data-container">
			<div class="Data1">
				<h1 class="gidole" style="color: #141942;">CANTIDAD A PAGAR</h1>
				<h2 class="gidole" style="color: #C1482F;">${{$charge->amount}}<span>MXN</span></h2>
				<h1 class="gidole" style="color: #141942;">Fecha límite de pago:</h1>
				<h1 class="gidole" style="color: #5D5D5D; font-size: 17px;">25 de noviembre del 2014 - 3:20 PM</h1>
			</div>
			<div class="Adorno" style="display:none;">
				<img src="{{asset('images/comprobante/tira.png')}}" alt="tira">
				<span>¡ESPERAMOS TU PAGO!</span>
			</div>
			<div class="Spei-stuff">
				<a href="#"><img src="{{asset('images/comprobante/spei.gif')}}" alt="SPEI"></a>
			</div>
			<div class="Data_bank">
				<h1 style="padding-bottom:20px; color: #141942;" class="gidole">Datos para transferencia electrónica</h1>
				<p class="gidole">Nombre del banco: SIS TRANSF y PAGOS (STP)</p>
				<p class="gidole">CLABE: {{$charge->payment_method->clabe}}</p>
				<p class="gidole">Referencia numérica: {{$charge->payment_method->name}}</p>
				<p class="gidole">Concepto de pago: {{$charge->payment_method->name}}</p>
			</div>
		</div>
		<div class="cont-text">
			<p style="padding-right: 100px;" class="gidole">Una vez que realices tu pago, tu póliza de seguro llegará al correo: <strong style="color: #C1482F;">{{$email}}</strong><br><br>
			¿Tienes alguda duda o problema? Escíbenos a: <br>
			<a href="mailto:contacto@aseguro.mx"><strong>contacto@aseguro.mx</strong></a></p>
		</div>
		<div class="buttons gidole">
			<a href="javascript:void(0)" onclick="window.print()">Imprimir póliza</a>
		</div>
		<div class="Yellow3">
		</div>
	</div>
	<div class="powered">
		<img src="{{asset('images/comprobante/powered_openpay.png')}}" alt="Powered by Openpay">
	</div>
</body>
</html>';