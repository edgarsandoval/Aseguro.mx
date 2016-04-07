<div id="background-completar">
	<p class="gidole title-completar">
		<span>¡Hola {{ $nombre }}! </span>
		Completa el formulario para efectuar tu pago
	</p>
	<div id="tabla-formulario" class="row gidole">
		{{-- <div class="col-md-2">Filtro</div> --}}
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-4">&nbsp;</div>
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-2">&nbsp;</div>
	</div>

	<div class="form-body">
		<div class="row">		
			<div class="col-md-2 form-info">
				<p class="gidole"><span>COSTO TOTAL</span></p>
				<h1 class="gidole">${{number_format($pago, 2, '.', ',')}}</h1>

				<p class="gidole">Cobertura<br><span>{{ $cobertura }}</span></p>
				<p class="gidole">Pago<br><span>{{ $formato }}</span></p>
				<p class="gidole" style="text-transform: uppercase;margin-top: 1em;">{{ $descripcion }}</p>
			</div>
			<div class="col-md-2" style="padding: 0;">
				<div class="option-container">
					<div class="gidole form-option selected">Datos Asegurado</div>
				</div>
				<div class="option-container">
					<div class="gidole form-option">Datos Asegurado</div>
				</div>
				<div class="option-container">
					<div class="gidole form-option">Información Pago</div>
				</div>
			</div>
			<div class="col-md-8 form-content">
				<div id="form-page-1">
					<div class="row">					
						<div class="col-md-4">
							<p class="gidole">Persona:</p>
							<div class="row" style="margin-top: -1.5em;">
								<div class="col-md-6">
									<div class="radio">
										<label>
											<input type="radio" name="frm-persona" value="H" checked>
										    Física
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="radio">
									 	<label>
									    	<input type="radio" name="frm-persona" value="M">
									    	Moral
									  	</label>
									</div>
								</div>
							</div>
							<input type="text" name="frm-nombre" placeholder="Nombre">
						</div>
						<div class="col-md-4">
							<p class="gidole">Sexo:</p>
							<div class="row" style="margin-top: -1.5em;">
								<div class="col-md-6">
									<div class="radio">
										<label>
											<input type="radio" name="frm-sexo" value="H" checked>
										    Hombre
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="radio">
									 	<label>
									    	<input type="radio" name="frm-sexo" value="M">
									    	Mujer
									  	</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>