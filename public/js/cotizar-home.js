$(document).ready(function()
{
	$('#btn-filtrar').click(procesarFiltro);
});

function procesarFiltro()
{
	if($('#filtrar').val() == null)
	{
		$('#common-modal p').html('Selecciona un filtro de la lista');
		$('#common-modal').modal();
	}

	var tipo = parseInt($('#filtrar').val());
	var cotizacionFiltrada = $.extend(true, {}, cotizacion);


	console.log("Filtro: " + tipo);

	//array('2' => 'Amplia', '4' => 'Limitada', '5' => 'RC', '3' => 'Limitada Plus', '1' => 'Super Amplia');

	switch(tipo)
	{
		case 1:
			var A = cotizacionFiltrada.Detalles.Detalle;
			console.log(A);

			for(var i = 0; i < cotizacionFiltrada.Detalles.Detalle.length; i++)
			{
				for(var j = 0; j < cotizacionFiltrada.Detalles.Detalle.length - 1; j++)
				{
					//parseInt(cotizacion.Detalles.Detalle[0].Montos.PrimaNeta) Lógica del arreglo. 
					//Swapping element in if statement    
					if(parseFloat(A[j].Montos.PrimaTotal) > parseFloat(A[j + 1].Montos.PrimaTotal))
					{
						var aux = A[j];
						A[j] = A[j+1];
						A[j + 1] = aux;        
					}
				}         
			}

			console.log(A);

			cotizacionFiltrada.Detalles.Detalle = A;
			llenarCotizacion(cotizacionFiltrada);
			break;

		case 2:
			var A = cotizacionFiltrada.Detalles.Detalle;
			var validas = [];

			console.log(A);
			for(var i = 0; i < cotizacionFiltrada.Detalles.Detalle.length; i++)
			{
				if(A[i].Paquete == '5')
					validas.push(A[i]);
			}

			console.log(validas);
			cotizacionFiltrada.Detalles.Detalle = validas;
			llenarCotizacion(cotizacionFiltrada);
			break;

		case 3:
			var A = cotizacionFiltrada.Detalles.Detalle;
			var validas = [];

			console.log(A);
			for(var i = 0; i < cotizacionFiltrada.Detalles.Detalle.length; i++)
			{
				if(A[i].Paquete == '4')
					validas.push(A[i]);
			}

			console.log(validas);
			cotizacionFiltrada.Detalles.Detalle= validas;
			llenarCotizacion(cotizacionFiltrada);
			break;

		case 4:
			var A = cotizacionFiltrada.Detalles.Detalle;
			var validas = [];

			console.log(A);
			for(var i = 0; i < cotizacionFiltrada.Detalles.Detalle.length; i++)
			{
				if(A[i].Paquete == '2')
					validas.push(A[i]);
			}

			console.log(validas);
			cotizacionFiltrada.Detalles.Detalle= validas;
			llenarCotizacion(cotizacionFiltrada);
			break;
	}	
}

/**
NUEVA FUNCIÓN, YA PONE LOS NÚMEROS, por hacerlo rápido y no usar AJAX. :c

Consultas en O(n) papá. :V
**/ 

function llenarCotizacion(cotizacionFiltrada) // Función para dibujar las nuevas filas, funciona. ;)
{
	$('.cotizaciones').empty();

	// Definicion de una variable local de PHP para reutilización de código. 
	var paquete = new Array(null, 'Super Amplia', 'Amplia', 'Limitada Plus', 'Limitada', 'RC');

	for(var i = 0; i < cotizacionFiltrada.Detalles.Detalle.length; i++)
	{
		var resultado = $('<div>').attr('id', cotizacionFiltrada.Detalles.Detalle[i].id).attr('class', 'row gidole fila-cotizar').attr('style', 'border-bottom: 2px solid #eee;');

		var resultadoCompania = $('<div>').attr('class', 'col-md-3').attr('style', 'display: flex; align-items: center;');
		for(var j = 0; j < companias.Compania.length; j++)
		{
			if(companias.Compania[j].Id == cotizacionFiltrada.Detalles.Detalle[i].Compania)
				resultadoCompania.append($('<span>', {
					'style' : 'text-align: center'
				}).append($('<a>',{
					'href' : companiasInfo[parseInt(companias.Compania[j].Id)]['Pagina'],
					'target' : '_blank'
					}).append($('<img>').attr({
						'src' : companias.Compania[j].Img,
						'style' : 'text-align: center;'
					}))
				).append($('<p>', {
					'class' : 'gidole',
					'style' : 'text-align: center; font-size: 1.5em; font-weight: bold;',
					'html' : companias.Compania[j].Nombre,
				})).append($('<p>', {
					'style' : 'text-align: center;',
					'html' : companiasInfo[parseInt(companias.Compania[j].Id)]['Telefono']
				}))).appendTo(resultado);
		}

		var resultadoInformacion = $('<div>').attr('class', 'col-md-4').attr('style', 'background-color: #F9F9F9;');

		var masInfo = $('<div>').attr('class', 'row');

		$('<div>', {
			'class' : 'col-md-6' 
		})
		.append($('<p>').append($('<b>').html('Paquete : ')).append(paquete[parseInt(cotizacionFiltrada.Detalles.Detalle[i].Paquete)]))
		.append($('<p>').append($('<b>').html('Prima Neta :')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaNeta, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('Gastos Expedicion :')).append(' $ ' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.GastosExpedicion, 2, '.', ',')))
		.appendTo(masInfo);

		$('<div>', {
			'class' : 'col-md-6' 
		})
		.append($('<p>').append($('<b>').html('Recargos :')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.Recargos, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('Descuento :')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.Descuento, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('IVA :')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.IVA, 2, '.', ',')))
		.appendTo(masInfo);

		resultadoInformacion.append(masInfo);

		resultadoInformacion.appendTo(resultado);

		resultadoPrecio = $('<div>').attr('class', 'col-md-3').attr('style', 'display: flex;align-items: center;');

		resultadoPrecio.append($('<p>').attr('class', 'costo-anual').html('$' + parseFloat(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaTotal))).appendTo(resultado);

		resultadoContratar = $('<div>').attr('class', 'col-md-2').attr('style', 'background-color: #F9F9F9; text-align: center;');

			FormularioContratar = $('<form>').attr('action', 'pagar').attr('method', 'POST').attr('id', 'frm-' + cotizacionFiltrada.Detalles.Detalle[i].id);
			
			FormularioContratar.append($('<input>').attr('type', 'hidden').attr('name', 'id').val(cotizacionFiltrada.Detalles.Detalle[i].id));
			FormularioContratar.append($('<input>').attr('type', 'hidden').attr('name', 'monto').val(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaTotal));

			for(var k in cliente)
			{
				FormularioContratar.append($('<input>').attr('type', 'hidden').attr('name', k).val(cliente[k]));
			}

			//var k = 1;

			// form

			// for(var k = 1; k <= 3; k++)
			// {
				FormularioContratar.append('<div class="row" style="text-align: left; padding: 0">' +
						'<div class="col-md-12" style="padding: 0;">' +
							'<div class="radio">' +
								'<label>' +
										'<input type="radio" name="opcion" value="1" checked>' +
							    		'Pago Bancario' +
								'</label>' +
							'</div>' +
						'</div>' +
					'</div>'
				);

				FormularioContratar.append('<div class="row" style="text-align: left; padding: 0">' +
						'<div class="col-md-12" style="padding: 0;">' +
							'<div class="radio">' +
								'<label>' +
										'<input type="radio" name="opcion" value="2">' +
							    		'Pago Tarjeta' +
								'</label>' +
							'</div>' +
						'</div>' +
					'</div>'
				);

				FormularioContratar.append('<div class="row" style="text-align: left; padding: 0">' +
						'<div class="col-md-12" style="padding: 0;">' +
							'<div class="radio">' +
								'<label>' +
										'<input type="radio" name="opcion" value="3">' +
							    		'Pago en Tiendas' +
								'</label>' +
							'</div>' +
						'</div>' +
					'</div>'
				);
			// }

			FormularioContratar.append($('<div>').attr('class', 'col-md-12').attr('style', 'padding: 0 !important;').append(
				$('<input>').attr('type', 'submit').attr('id', 'btn' + cotizacionFiltrada.Detalles.Detalle[i].id).attr('class', 'btn btn-default').val('PROCEDER PAGO')
				)
			).appendTo(resultadoContratar);

		resultadoContratar.append($('<p>').attr('class', 'gidole').html('ó'));

		resultadoContratar.append($('<div>').attr('class', 'col-md-12').append(
						'<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">' +
					        '<input type="hidden" name="cmd" value="_xclick">' +
					        '<input type="hidden" name="business" value="edgar@sitiorandom.com">' +
					        '<input type="hidden" name="item_name" value="Póliza aseguro.mx">' +
					        '<input type="hidden" name="currency_code" value="MXN">' +
					        '<input type="hidden" name="amount" value="' + cotizacionFiltrada.Detalles.Detalle[i].MontosPrimaTotal+ '">' +
					        '<input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">' +
					    '</form>' 
			)
		).appendTo(resultado);

		$('.cotizaciones').append(resultado);

	}
}

function opcionRadio(k)
{
	if(k == 1)
		return $('<label>').append($('<input>').attr('type', 'radio').attr('name', 'opcion').val(k).attr('checked', true)).append('Pago Bancario');
	if(k == 2)
		return $('<label>').append($('<input>').attr('type', 'radio').attr('name', 'opcion').val(k)).append('Pago Tarjeta');
	else
		return $('<label>').append($('<input>').attr('type', 'radio').attr('name', 'opcion').val(k)).append('Pago en Tiendas');
}


function number_format(n, c, d, t)
{
	var n = n, 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
	    j = (j = i.length) > 3 ? j % 3 : 0;

   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

// for(var k = 1; k <= 3; k++)
// {
// 	FormularioContratar.append($('<div>').attr('class', 'row').attr('style', 'text-align: left; padding: 0;').append(
// 			$('div').attr('class', 'col-md-12').attr('style', 'padding: 0;').append(
// 				$('<div>').attr('class', 'radio').append(
// 					opcionRadio(k)
// 				)
// 			)
// 		)
// 	);
// }