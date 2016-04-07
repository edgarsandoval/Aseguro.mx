<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Aseguro :: Webpage consulta todo</title>

	<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

	<!-- CSS's -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://css-plus.com/examples/2013/10/jquery-image-slider/fancybox/jquery.fancybox-1.3.1.css">
	<link rel="stylesheet" href="{{ asset('css/common.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
	

	{{ HTML::style( asset('css/aseguros.css')) }}
	@yield('style')

	<!--  JS's -->
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
	<script src="https://rawgit.com/bencorlett/jquery-before-after/master/jquery.beforeafter-1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="http://css-plus.com/examples/2013/10/jquery-image-slider/fancybox/jquery.fancybox-1.3.1.js"></script>
  	<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
	<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
	<script src="{{ asset('js/common.js') }}"></script>

	{{ HTML::script( asset('js/aseguros.js')) }}
	@yield('script')

	<!--Start of Zopim Live Chat Script-->
	<script type="text/javascript">
	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
	$.src="//v2.zopim.com/?3josboGJ1qGXWp663zVRIc8LpQwdmFrg";z.t=+new Date;$.
	type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
	</script>
	<!--End of Zopim Live Chat Script-->

</head>
<body>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T4NFSB"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-T4NFSB');</script>
	<!-- End Google Tag Manager -->
	<div id="header">
		<div class="row">
			<div class="col-md-2">
				<img src="{{ asset('images/home/home-logo.png') }}" alt="logo">
			</div>
			<div class="col-md-8">
				<nav class="navbar navbar-default">
					<div class="nav-control"></div>
					<div class="container-fluid">
					<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse">
						  <ul class="nav navbar-nav gidole">
						    <li>{{ HTML::link('/#home', 'Home') }}</li>
						    <li>{{ HTML::link('/#promesa-aseguro', 'Promesa Aseguro') }}</li>
						    <li>{{ HTML::link('/#cotiza', 'COTIZA') }}</li>
						    <li>{{ HTML::link('/#aseguros','Aseguradoras') }}</li>
						    <li>{{ HTML::link('/#contacto', 'Contacto') }}</li>		    
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>

	<div id="main">
		@yield('home')
	</div>
	
	<div id="aseguros">
		@yield('aseguros')
	</div>

	<div id="banner">
		@yield('banner')
	</div>

	<div id="footer">
		<div class="row">
			<div class="col-md-2" style="padding-top: 2em; padding-left: 2em;">
				<img src="{{ asset('images/aseguro.png') }}" alt="aseguro">

				<p class="gidole" style="bottom: 2em; position: absolute;"><a href="aviso-privacidad" target="_blank">AVISO DE PRIVACIDAD</a></p>
				
				<p class="gidole" style="margin-top: 2em; display: none;">
					Av. Patria #5846<br>
					Zapopan, Jalisco, México<br>
					C.P. 45070<br>
				</p>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-6" style="padding-top: 6em;">
				<div style="border-bottom: 2px solid #EC4424;">
					<div class="row">
						<div class="col-md-6 gidole" style="font-size: .8vw; text-align: center;">
							<i class="fa fa-envelope"></i>&nbsp;atencion@aseguro.mx
						</div>
						<div class="col-md-6" style="text-align: center;">
							<span style="font-size:1.4vw;">
								<a href="http://www.facebook.com/aseguromx/" target="_blank"><i class="fa fa-facebook"></i></a> &nbsp;
								<a href="http://www.twitter.com/aseguromx/" target="_blank"><i class="fa fa-twitter"></i></a> &nbsp;
								<a href="http://www.instagram.com/aseguromx/" target="_blank"><i class="fa fa-instagram"></i></a> &nbsp;
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="container-fluid" style="text-align: center;">
						<ul id="footer-menu" class="gidole">
							<li>{{ HTML::link('/#home', 'Home') }}</li>
						    <li>{{ HTML::link('/#promesa-aseguro', 'Promesa Aseguro') }}</li>
						    <li>{{ HTML::link('/#cotiza', 'COTIZA') }}</li>
						    <li>{{ HTML::link('/#aseguros','Aseguradoras') }}</li>
						    <li>{{ HTML::link('/#contacto', 'Contacto') }}</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-2">
				<p class="gidole" style="bottom: 1em; position: absolute;">Hecho por: <a href="http://www.sitiorandom.com" target="_blank">RANDOM</a></p>
			</div>
		</div>
	</div>


	@yield('modals')
	
</body>
</html>