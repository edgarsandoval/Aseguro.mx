$(document).ready(function()
{
	var lastScrollTop = 0;
	$(window).scroll(function(event)
	{
		if($(this).scrollTop() + $(window).height() < $('#promesa-aseguro').position().top)
			return;

		var st = $(this).scrollTop();
		if(st > lastScrollTop)
		{
			if($('#auto-parallax').position().left +  $('#auto-parallax').width() < $(window).width() - 10)
				$('#auto-parallax').animate({left: '+=10'}, 10);	
		}
		else
		{
			if($('#auto-parallax').position().left > 10)
				$('#auto-parallax').animate({left: '-=10'}, 11);
		}
		lastScrollTop = st;
	});
});

