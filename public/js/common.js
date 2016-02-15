$(document).ready(function()
{
	var altura = $('#home').height() / 2;
	$('html, body').animate({'scrollTop' : 0});

	$(window).on('scroll', function()
	{
		if ($(window).scrollTop() > altura )
			$('#header').addClass('menu-fixed');
		else
			$('#header').removeClass('menu-fixed');
	});

	$('#menu_home').click(function(event)
	{
		event.preventDefault();
		$('html, body').animate({'scrollTop' : 0});
	});

	$('#menu_promesa-aseguro').click(function(event)
	{
		event.preventDefault();
		$('html, body').animate({'scrollTop' : $('#promesa-aseguro').position().top});
	});	

	$('#menu_cotiza').click(function(event)
	{
		event.preventDefault();
		$('html, body').animate({'scrollTop' : $('#cotiza').position().top});
	});

	$('#menu_aseguros').click(function(event)
	{
		event.preventDefault();
		$('html, body').animate({'scrollTop' : $('#aseguros').position().top});
	});

	$('#menu_contacto').click(function(event)
	{
		event.preventDefault();
		$('html, body').animate({'scrollTop' : $('#contacto').position().top});
	});

});




