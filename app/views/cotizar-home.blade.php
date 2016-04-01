<script type="text/javascript">
	var cotizacion = <?php echo json_encode($resultado); ?>; // Para mayor facilidad en cuanto a los filtros, por no hacer muchas consultas se guarda el objeto resultante;
	var companias = <?php echo json_encode($companias); ?>; // Requerido para hace la actualización de los resultados.
	var cliente = <?php echo json_encode($cliente); ?>; // También;
	var companiasInfo = <?php echo json_encode($companiasInfo); ?>;
</script>
<div id="background-cotizar-home" style="margin-bottom: 3em;">
	<p class="gidole title-cotizar">
		<span>¡Hola {{ $nombre }}! </span>
		Estos son los precios para asegurar tu
		<span>{{ $marca . ' ' . $submarca . ' ' . $modelo }}</span>
	</p>
	<div id="tabla-cotizar" class="row gidole">
		{{-- <div class="col-md-2">Filtro</div> --}}
		<div class="col-md-3">Aseguradora</div>
		<div class="col-md-3">Información</div>
		<div class="col-md-3">Precio anual</div>
		<div class="col-md-3">Contratar</div>
	</div>

	<div id="filtros" class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5">
			<span class="gidole">Filtrar por : </span>
			<select id="filtrar">
				<option selected disabled hidden value="0">Ningún filtro</option>
				<option value="1">Precio</option>
				<option value="2">Cobertura RC</option>
				<option value="3">Cobertura Limitada</option>
				<option value="4">Cobertura Amplia</option>
			</select>
		</div>
		<div class="col-md-1">
			<button id="btn-filtrar" class="btn btn-default">Filtrar</button>
		</div>
		<div class="col-md-3"></div>
	</div>

	<div class="cotizaciones">
		@for ($i = 0; $i < count($resultado->Detalles->Detalle); $i++) 
			<div id="{{$resultado->Detalles->Detalle[$i]->id}}" class="row gidole fila-cotizar" style="border-bottom: 2px solid #eee;">
				<div class="col-md-3" style="display: flex;align-items: center;">
					@for($j = 0; $j < count($companias->Compania); $j++)
						@if((string) $companias->Compania[$j]->Id === (string) $resultado->Detalles->Detalle[$i]->Compania)
							<span style="text-align: center;"><a href="{{$companiasInfo[intval($companias->Compania[$j]->Id)]['Pagina']}}" target="_blank"><img src="{{$companias->Compania[$j]->Img}}"></a></sapn>
							<p class="gidole" style="text-align: center; font-size: 1.5em; font-weight: bold;">{{ $companias->Compania[$j]->Nombre }}</p>
							<p class="gidole" style="text-align: center;">{{ $companiasInfo[intval($companias->Compania[$j]->Id)]['Telefono']}}</p>
						@endif
					@endfor
				</div>
				<div class="col-md-3" style="background-color: #F9F9F9;">
					<p><b>Paquete: </b> {{ $paquete[(string) $resultado->Detalles->Detalle[$i]->Paquete] }}</p>
					<p><b>Prima Neta</b> {{ '$' . $resultado->Detalles->Detalle[$i]->Montos->PrimaNeta }}</p>
					<p><b>Gastos Expedicion</b> {{ '$' . $resultado->Detalles->Detalle[$i]->Montos->GastosExpedicion }}</p>
					<p><b>Recargos</b> {{ '$' . $resultado->Detalles->Detalle[$i]->Montos->Recargos }}</p>
					<p><b>Descuento</b> {{ '$' . $resultado->Detalles->Detalle[$i]->Montos->Descuento }}</p>
					<p><b>IVA</b> {{ '$' . $resultado->Detalles->Detalle[$i]->Montos->IVA }}</p>
				</div>
				<div class="col-md-3" style="display: flex;align-items: center;">
					<p class="costo-anual"> {{ '$' . (float)$resultado->Detalles->Detalle[$i]->Montos->PrimaTotal }} </p>
				</div>
				<div class="col-md-3" style="background-color: #F9F9F9; text-align: center;">
					{{ Form::open(['action' => 'QuoteController@procesarPago', 'method' => 'POST', 'id' => 'frm-' . $resultado->Detalles->Detalle[$i]->id])}}
					<input type="hidden" name="id" value="{{$resultado->Detalles->Detalle[$i]->id}}">
					<input type="hidden" name="monto" value="{{$resultado->Detalles->Detalle[$i]->Montos->PrimaTotal}}">
					@foreach($cliente as $clave => $valor)
						<input type="hidden" name="{{$clave}}" value="{{$valor}}">
					@endforeach

					@for($k = 1; $k <= 3; $k++)
					<div class="row" style="text-align: left; padding: 0">
						<div class="col-md-12" style="padding: 0;">
							<div class="radio">
								<label>
									@if($k == 1)
										<input type="radio" name="opcion" value="{{$k}}" checked>
							    		Pago Bancario
									@elseif($k == 2)
										<input type="radio" name="opcion" value="{{$k}}">
							    		Pago Tarjeta
									@else
										<input type="radio" name="opcion" value="{{$k}}">
							    		Pago en Tiendas
									@endif
								</label>
							</div>
						</div>
					</div>
					@endfor
					<div class="col-md-12" style="padding: 0 !important;">
						<input type="submit" id="btn{{$resultado->Detalles->Detalle[$i]->id}}" class="btn btn-default" value="PROCEDER PAGO">
					</div>
					{{Form::close()}}
					<p class="gidole"> ó </p>
					<div class="col-md-12">
						<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
					        <input type="hidden" name="cmd" value="_xclick">
					        <input type="hidden" name="business" value="edgar@sitiorandom.com">
					        <input type="hidden" name="item_name" value="Póliza aseguro.mx">
					        <input type="hidden" name="currency_code" value="MXN">
					        <input type="hidden" name="amount" value="{{$resultado->Detalles->Detalle[$i]->Montos->PrimaTotal}}">
					        <input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
					    </form>
					</div>
				</div>
			</div>
		@endfor
	</div>

</div>