<div id="quote-background" style="background-image: url({{ asset('images/cotiza/fondo.jpg') }});">
	<p class="gidole" style="font-size: 2em;">Encuentra el mejor</p>
	<p class="gidole" style="font-size: 2em;">seguro para tu auto</p>
	{{ Form::open(['action' => 'HomeController@cotizar', 'method' => 'POST', 'id' => 'frm-cotizar']) }}
	<div id="quote-container">
		<div class="row">		
			<div class="col-md-3"></div>
			<div class="col-md-6">			
				<div id="form" class="row">
					<div class="col-md-6">
						<p class="gidole quote-text">.Datos auto a cotizar</p>
						<select id="vehicle-type" name="vehicle-type" onchange="loadModels()" required>
							<option selected disabled hidden value>Tipo de vehículo:</option>
							@foreach ($tipos  as $typo)
								<option value="{{$typo->TipoVehiculoBase}}">{{$typo->Descripcion}}</option>
							@endforeach
						</select>
						<select id="model" name="model" onchange="loadMarcas()" required>
							<option selected disabled hidden value>Modelo:</option>
						</select>

						<select id="trademark" name="trademark" onchange="loadSubMarcas()" required>
							<option selected disabled hidden value>Marca:</option>
						</select>

						<select id="sub-trademark" name="sub-trademark" onchange="loadDescription()" required>
							<option selected disabled hidden value>Submarca:</option>
						</select>

						<select id="description" name="description" required>
							<option selected disabled hidden value>Descripción</option>
						</select>
					</div>
					<div class="col-md-6">
						<p class="gidole quote-text">.Datos usuario</p>
						<div class="row">
							<input type="hidden" id="user-age" name="user-age" value>
							<div class="col-md-6">
								<input type="text" id="user-name" name="user-name" placeholder="Nombre" required>
								<input type="text" id="user-lastname" name="user-lastname" placeholder="Apellido Paterno" required>
								<input type="text" id="user-phone" name="user-phone" placeholder="Teléfono (opcional)">

							</div>
							<div class="col-md-6">
								<input type="email" id="user-email" name="user-email"  placeholder="E-mail" required>
								<p class="gidole">Sexo:</p>
								<div class="row" style="margin-top: -1.5em;">
									<div class="col-md-6">
										<div class="radio">
										<label>
											<input type="radio" name="user-gender" id="user-gender-man" value="H" checked>
										    Hombre
										  </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="radio">
										  <label>
										    <input type="radio" name="user-gender" id="user-gender-woman" value="M">
										    Mujer
										  </label>
										</div>
									</div>
								</div>
								<input type="text" id="user-phone" name="user-cellphone" placeholder="Celular (opcional)">
								<br>
								<br>
							</div>
							<div class="col-md-12">
								<p class="gidole">Fecha de nacimiento:</p>
								<div class="row">
									<div class="col-md-4">
										<select id="user-day" required>
											<option selected disabled hidden value> -- </option>
											@for($i = 31; $i >= 1; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor
										</select>
									</div>
									<div class="col-md-4">
										<select id="user-month" required>
											<option selected disabled hidden value> -- </option>
											@for($i = 12; $i >= 1; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor

										</select>
									</div>
									<div class="col-md-4">
										<select id="user-year" required>
											<option selected disabled hidden value> ---- </option>
											@for($i = 2016; $i >= 1916; $i--)
												<option value="{{$i}}">{{ ($i < 10 ? '0' . $i : $i ) }}</option>
											@endfor
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<p class="gidole">Zonificación.</p>
								<div class="row">
									<div class="col-md-5">
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

									<div class="col-md-3">
										<select id="cp" name="cp" required>
											<option selected disabled hidden value>CP:</option>
										</select>
									</div>
								</div>
					</div>

					<div class="col-md-12">
						<p class="gidole quote-text">.Forma de pago</p>
						<div class="row">
							<div class="col-md-3">
								<div class="radio">
									<label>
										<input type="radio" name="payment-method" value="4" checked>
										Mensual
									</label>
								</div>
							</div>

							<div class="col-md-3">
								<div class="radio">
									<label>
										<input type="radio" name="payment-method" value="3">
										Trimestral
									</label>
								</div>
							</div>

							<div class="col-md-3">
								<div class="radio">
									<label>
										<input type="radio" name="payment-method" value="2">
										Semestral
									</label>
								</div>
							</div>

							<div class="col-md-3">
								<div class="radio">
									<label>
										<input type="radio" name="payment-method" value="1">
										Anual
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 gidole" style="text-align: center;padding-top:2.5em;">
						<input type="button" id="btn-cotizar" value="COTIZAR">
						<input type="submit" id="btn-real">
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>