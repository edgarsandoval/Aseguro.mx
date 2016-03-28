$(document).ready(function()
{
	if($(window).width() < 900)
			$('nav.navbar').addClass('mobile-menu');
		
	var altura = $('#home').height() / 2;
	$('html, body').animate({'scrollTop' : 0});

	$(window).on('scroll', function()
	{
		if ($(window).scrollTop() > altura && !$('nav.navbar').hasClass('mobile-menu'))
			$('#header').addClass('menu-fixed');
		else
			$('#header').removeClass('menu-fixed');
	});
	// $('a[href^="#"]').click(function(event)
	// {
 //    	var target = $('#' + this.href.split('#')[1]);

 //    	if(target.length)
 //    	{
 //        	event.preventDefault();
 //        	$('html, body').animate(
 //        	{
 //            	scrollTop: target.offset().top
 //            }, 1000);
 //    	}
	// });

	$(window).resize(function()
	{
		if($(window).width() < 900)
			$('nav.navbar').addClass('mobile-menu');
		else
			$('nav.navbar').removeClass('mobile-menu');
	});

	$('.nav-control').click(function()
	{
		var h = $(".mobile-menu ul").height();
    	if(h > 1)
      		$(".mobile-menu ul").css("max-height","0");
    	else
      		$(".mobile-menu ul").css("max-height","300px");
	});

});




