<div id="background-contact">
	<p class="gidole" style="font-size: 2em; margin-bottom: 1em;">¡Contáctanos!</p>
	{{ Form::open(['action' => 'HomeController@contacto', 'method' => 'POST', 'role' => 'form'])}}
		<div class="row">
			<div class="col-md-6">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-6">
							<input type="text" id="contact-name" class="gidole" name="contact-name" placeholder="Nombre:">
						</div>
						<div class="col-md-6">
							<input type="text" id="contact-mail" class="gidole" name="contact-mail" placeholder="Correo:">
						</div>
					</div>
					<div class="col-md-12" style="padding: 0 !important;">
						<textarea id="contact-message" class="gidole" name="contact-message" rows="10" placeholder="Mensaje:"></textarea>
					</div>
					<div class="col-md-12" style="padding: 0 !important; margin-top: 1em;">
						<input type="submit" id="btn-enviar" class="gidole" value="ENVIAR">
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-6">
				<div class="col-md-3"></div>
				<div class="col-md-5" style="padding-top: 100px;">
					<p><i class="fa fa-envelope" style="color: #0D0F42;"></i>&nbsp;&nbsp;<span class="gidole" style="color: #0D0F42; font-size: 1.4em;">contacto@aseguro.mx</span></p>
					<div class="col-md-12" style="text-align: center;">
						<a href="http://www.facebook.com/aseguromx/" target="_blank"><img src="{{ asset('images/contacto/social-facebook.png') }}" alt="social-facebook"></a>
						<a href="http://www.twitter.com/aseguromx/" target="_blank"><img src="{{ asset('images/contacto/social-twitter.png') }}" alt="social-twitter"></a>
						<a href="http://www.instagram.com/aseguromx/" target="_blank"><img src="{{ asset('images/contacto/social-instagram.png') }}" alt="social-instagram"></a>
					</div>

				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
	{{ Form::close() }}
</div>