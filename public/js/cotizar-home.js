$(document).ready(function()
{
	$('#btn-filtrar').click(procesarFiltro);

	$('#btn-cambiar').click(procesarFormato);

	$('.btn-cotizar').click(cargarDatos);
});

function cargarDatos()
{
	var idCotizacion = $(this).attr('charge-data');
	console.log(idCotizacion);

	$('#cotizacion-id').val(idCotizacion);
	$('#pago').val(parseFloat($('div#' + idCotizacion + ' .col-md-3:last p').html().split('$')[1].split(',').join('')));
	$('#cobertura').val($('div#' + idCotizacion + ' .col-md-6 p:first').html().trim().split(' ')[2]);
	$('#formato').val($('input[type="radio"]:checked').parent().html().trim().split('>')[1].trim());
	$('#recibos').val(parseFloat($('div#' + idCotizacion + ' p.costo-anual + p').html().split('$')[1].split('<')[0].split(',').join('')));

	$('form').submit();
}

function procesarFormato()
{
	var formato = $('input[type="radio"]:checked').val();

	$.ajax(
	{
		url : 'cambiar-formato',
		type : 'POST',
		data :
		{
			'datos' : $('#datos').val(),
			'forma-pago' : formato
		},
		beforeSend: function()
		{
        	$('#loading-modal').modal();
    	},
		success : function(response)
		{
			$('#loading-modal').modal('hide');
			console.log(response);
			cotizacion = $.parseJSON(response);
			llenarCotizacion($.parseJSON(response));
		}
	});
}

function procesarFiltro()
{
	if($('#filtrar').val() == 0)
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

// DESPUÉS DE HACER LA NUEVA CONSULTA CON AJAX SE PASA COMO PARAMETRO EL RESULTADO, SIN PEDOS JAJAJAJA ME ENCANTA

function llenarCotizacion(cotizacionFiltrada) // Función para dibujar las nuevas filas, funciona. ;)
{
	$('.cotizaciones').empty();

	if(!('Detalle' in cotizacionFiltrada.Detalles) || cotizacionFiltrada.Detalles.Detalle.length == 0)
	{
		$('#common-modal p').html('No hay resultados para este filtro / formato de pago <br> Por favor, inenta con otra opcion.');
		$('#common-modal').modal();
		return;
	}

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
			'class' : 'col-md-6',
			'style' : 'padding: 0 !important;'
		})
		.append($('<p>').append($('<b>').html('Paquete: ')).append(paquete[parseInt(cotizacionFiltrada.Detalles.Detalle[i].Paquete)]))
		.append($('<p>').append($('<b>').html('Prima Neta:')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaNeta, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('Gastos Expedicion:')).append(' $ ' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.GastosExpedicion, 2, '.', ',')))
		.appendTo(masInfo);

		$('<div>', {
			'class' : 'col-md-6',
			'style' : 'padding: 0 !important;'
		})
		.append($('<p>').append($('<b>').html('Recargos:')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.Recargos, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('Descuento:')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.Descuento, 2, '.', ',')))
		.append($('<p>').append($('<b>').html('IVA:')).append(' $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.IVA, 2, '.', ',')))
		.appendTo(masInfo);

		resultadoInformacion.append(masInfo);

		resultadoInformacion.appendTo(resultado);

		resultadoPrecio = $('<div>').attr('class', 'col-md-3').attr('style', (cotizacionFiltrada.FormaPago == 5 ? 'display: flex; align-items: center;' : 'text-align: center;'));

		if(cotizacionFiltrada.FormaPago == 5)
			resultadoPrecio.append($('<p>').attr('class', 'costo-anual').html('$' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaTotal, 2, '.', ','))).appendTo(resultado);
		else
			resultadoPrecio.append($('<p>').attr('class', 'costo-anual').html('$' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Recibos.PrimaTotal_1er, 2, '.', ',')))
						   .append($('<p>', {
						   		'style' : 'font-size: 1.3em; margin-top: .8em;'
						   }).html('Los siguientes <b>' + cotizacionFiltrada.Detalles.Detalle[i].Recibos.NumRecibos_Sub + '</b> recibos de : <b> $' + number_format(cotizacionFiltrada.Detalles.Detalle[i].Recibos.PrimaTotal_Sub ) + '</b>' ))
						   .appendTo(resultado);
		
		resultadoContratar = $('<div>').attr({
				'class' : 'col-md-2',
				'style' : 'display: flex; align-items: center; background-color: #F9F9F9; text-align: center;'
			});

			
			//FormularioContratar.append($('<input>').attr('type', 'hidden').attr('name', 'id').val(cotizacionFiltrada.Detalles.Detalle[i].id));
			//FormularioContratar.append($('<input>').attr('type', 'hidden').attr('name', 'monto').val(cotizacionFiltrada.Detalles.Detalle[i].Montos.PrimaTotal));

		resultadoContratar.append($('<div>', {
			'class' : 'col-md-12',
			'style' : 'padding: 0 !important;'
		}).append($('<input>', {
			'type' : 'button',
			'charge-data' : cotizacionFiltrada.Detalles.Detalle[i].id,
			'class' : 'btn-cotizar btn btn-default btn-lg',
			'value' : 'PROCEDER PAGO'
		}))).appendTo(resultado);

		$('.cotizaciones').append(resultado);
		$('.btn-cotizar').click(cargarDatos);

	}
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
