
<script type="text/javascript">
	var cotizacion = <?php echo json_encode($cotizacion); ?>; // Para mayor facilidad en cuanto a los filtros, por no hacer muchas consultas se guarda el objeto resultante;
	var companias = <?php echo json_encode($companias); ?>; // Requerido para hace la actualización de los resultados.
	var cliente = <?php echo json_encode($cliente); ?>; // También;
	var companiasInfo = <?php echo json_encode($companiasInfo); ?>;
</script>
<div id="background-cotizar-home" style="margin-bottom: 3em;">
	<p class="gidole title-cotizar">
		<span>¡Hola {{ $cliente['nombre'] }}! </span>
		Estos son los precios para asegurar tu
		<span>{{ $marca . ' ' . $submarca . ' ' . $modelo }}</span>
	</p>
	<div id="tabla-cotizar" class="row gidole">
		{{-- <div class="col-md-2">Filtro</div> --}}
		<div class="col-md-3">Aseguradora</div>
		<div class="col-md-4">Información</div>
		<div class="col-md-3">Precio anual</div>
		<div class="col-md-2">Contratar</div>
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
		@for ($i = 0; $i < count($cotizacion->Detalles->Detalle); $i++) 
			<div id="{{$cotizacion->Detalles->Detalle[$i]->id}}" class="row gidole fila-cotizar" style="border-bottom: 2px solid #eee;">
				<div class="col-md-3" style="display: flex;align-items: center;">
					@for($j = 0; $j < count($companias->Compania); $j++)
						@if((string) $companias->Compania[$j]->Id === (string) $cotizacion->Detalles->Detalle[$i]->Compania)
							<span style="text-align: center;"><a href="{{$companiasInfo[intval($companias->Compania[$j]->Id)]['Pagina']}}" target="_blank"><img src="{{$companias->Compania[$j]->Img}}"></a></sapn>
							<p class="gidole" style="text-align: center; font-size: 1.5em; font-weight: bold;">{{ $companias->Compania[$j]->Nombre }}</p>
							<p class="gidole" style="text-align: center;">{{ $companiasInfo[intval($companias->Compania[$j]->Id)]['Telefono']}}</p>
						@endif
					@endfor
				</div>
				<div class="col-md-4" style="background-color: #F9F9F9;">
					<div class="row">
						<div class="col-md-6" style="padding: 0;">
							<p><b>Paquete: </b> {{ $paquete[(string) $cotizacion->Detalles->Detalle[$i]->Paquete] }}</p>
							<p><b>Prima Neta: </b> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->PrimaNeta, 2, '.', ',') }}</p>
							<p><b>Gastos Expedicion: </b> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->GastosExpedicion, 2, '.', ',') }}</p>
						</div>
						<div class="col-md-6" style="padding: 0;">
							<p><b>Recargos: </b> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->Recargos, 2, '.', ',') }}</p>
							<p><b>Descuento: </b> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->Descuento, 2, '.', ',') }}</p>
							<p><b>IVA: </b> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->IVA, 2, '.', ',') }}</p>
						</div>
					</div>
				</div>
				<div class="col-md-3" style="display: flex;align-items: center;">
					<p class="costo-anual"> {{ '$' . number_format($cotizacion->Detalles->Detalle[$i]->Montos->PrimaTotal, 2, '.', ',') }} </p>
				</div>
				<div class="col-md-2" style="display: flex;align-items: center;background-color: #F9F9F9; text-align: center;">
					<div class="col-md-12" style="padding: 0 !important;">
						<input type="submit" id="btn{{$cotizacion->Detalles->Detalle[$i]->id}}" class="btn-cotizar btn btn-default btn-lg" value="PROCEDER PAGO">
					</div>
				</div>
			</div>
		@endfor
	</div>

</div>