$(document).ready(function()
{
	$('.option-container').css('height', $('.form-body').height() / 3);
	$('.form-option').click(function()
	{
		$('.form-option').removeClass('selected');
		$(this).addClass('selected');
	});
});