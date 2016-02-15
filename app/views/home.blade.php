@if(isset($_GET['message']))
	<input id="mensaje" type="hidden" value="{{ $_GET['message']}}">
@endif
<div id="openModal" class="modalDialog">
    <div>
			<p style="margin-bottom: 3em;"><img src="{{ asset('images/home/modal-logo.png') }}" alt="modal-logo"></p>
			<p><img src="{{ asset('images/home/flecha.png') }}" alt="flecha" class="animated bounce"></p>
    		<a href="#close" title="close" class="jenna-sue close">Estas a un click de asegurarte!</a>

    </div>
</div>
<div id="background-home">
	<img src="{{ asset('images/home/home-logo.png') }}" alt="home-logo">
	<div id="container">
		<div><img src="{{ asset('images/home/carrochocado.jpg') }}" alt="carrochocado"></div>
		<div><img src="{{ asset('images/home/carro.png') }}" alt="carro"></div>
	</div>
</div>