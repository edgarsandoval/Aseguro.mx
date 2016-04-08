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
					</div>

					<div class="row">
						<div class="col-md-4">
							<input type="text" name="frm-nombre" placeholder="Nombre" required>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-apellidop" placeholder="Apellido paterno" required>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-apellidom" placeholder="Apellido materno" required>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<select>
								<option value="Estado Civil"></option>
							</select>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-rfc" placeholder="RFC" required>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-curp" placeholder="CURP(opcional)">
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<input type="text" name="frm-ocupacion" placeholder="Ocupación" required>
						</div>
						<div class="col-md-4">
							<p class="gidole">Politicamente expuesto:</p>
							<div class="row" style="margin-top: -1.5em;">
								<div class="col-md-6">
									<div class="radio">
										<label>
											<input type="radio" name="frm-expuesto" value="H" checked>
										    Sí
										</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="radio">
									 	<label>
									    	<input type="radio" name="frm-expuesto" value="M">
									    	No
									  	</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<p class="gidole">Fecha de nacimiento:</p>
								<div class="row">
									<div class="col-md-4" style="padding-right: 0;">
										<select id="user-day" required>
											<option selected disabled hidden value> -- </option>
											@for($i = 31; $i >= 1; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor
										</select>
									</div>
									<div class="col-md-4" style="padding-right: 0;">
										<select id="user-month" required>
											<option selected disabled hidden value> -- </option>
											@for($i = 12; $i >= 1; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor

										</select>
									</div>
									<div class="col-md-4" style="padding-right: 0;">
										<select id="user-year" required>
											<option selected disabled hidden value> ---- </option>
											@for($i = 2016; $i >= 1916; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor
										</select>
									</div>
								</div>
						</div>

						<div class="col-md-4" style="padding-top: 2em;">
							<select>
								<option value="1">Pais</option>		
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<select id="estados" name="estados" onchange="loadMunicipios()" required>
								<option selected disabled hidden value>Estados:</option>
								@foreach ($estados  as $estado)
									<option value="{{$estado->ClaveEstado}}">{{$estado->Estado}}</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-4">
							<select id="municipios" name="municipios" onchange="loadCP()" required>
								<option selected disabled hidden value>Municipios:</option>
							</select>
						</div>

						<div class="col-md-4">
							<select id="cp" name="cp" required>
								<option selected disabled hidden value>CP:</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<input type="text" name="frm-colonia" placeholder="Colonia" required>
						</div>

						<div class="col-md-4">
							<input type="text" name="frm-calle" placeholder="Calle" required>
						</div>
						<div class="col-md-4">
							<div class="row" style="margin: 0">
								<div class="col-md-6" style="padding-left: 0;">
									<input type="text" name="frm-noext" placeholder="No. ext" required>
								</div>
								<div class="col-md-6" style="padding-right: 0;">
									<input type="text" name="frm-noint" placeholder="No. int">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<input type="text" name="frm-telefono" placeholder="Teléfono" required>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-celular" placeholder="Celular" required>
						</div>
						<div class="col-md-4">
							<input type="text" name="frm-correo" placeholder="E-mail" required>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12" style="text-align: center;">
			<button class="gidole btn btn-default btn-lg">Continuar>></button>
		</div>
	</div>
</div>