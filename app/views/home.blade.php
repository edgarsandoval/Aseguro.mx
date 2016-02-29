<input id="mensaje" type="hidden" value="{{ $mensaje ? : 'null' }}">
<div id="background-home">
	<img src="{{ asset('images/home/home-logo.png') }}" alt="home-logo">
	<div id="container">
		<div><img src="{{ asset('images/home/carrochocado.jpg') }}" alt="carrochocado"></div>
		<div><img src="{{ asset('images/home/carro.png') }}" alt="carro"></div>
	</div>
</div>

<!-- Modal Home-->
<div class="modal fade" id="home-modal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title"></h4>
	    </div>
	    <div class="modal-body">
	      <div style="text-align: center;">
			<p style="margin-bottom: 3em;"><img src="{{ asset('images/home/modal-logo.png') }}" alt="modal-logo"></p>
			<p><img src="{{ asset('images/home/flecha.png') }}" alt="flecha" class="animated bounce"></p>
    		

    	</div>
	    </div>
	    <div class="modal-footer" style="text-align: center;">
	      <a href="#" class="jenna-sue close" data-dismiss="modal">Estas a un click de asegurarte!</a>
	    </div>
	  </div>
	  
	</div>
</div>


<!-- Modal Common -->
<div class="modal fade" id="common-modal" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title gidole"><b>Mensaje del servidor (Aseguro.mx)</b></h4>
	    </div>
	    <div class="modal-body">
	    	<p class="gidole" style="font-size: 1.2em; padding-left: 1em;"></p>
	    </div>
	    <div class="modal-footer">
			<button type="button" class="btn btn-default btn-close gidole" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	  
	</div>
</div>