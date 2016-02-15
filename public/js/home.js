$(document).ready(function()
{
	if($('#mensaje').val() == "sucess")
	{
		alert("Mensaje enviado con exito. :)");
		// window.location.reload();
	}
	else if($('#mensaje').val())
		alert($('#mensaje').val())
	window.location.href = '#openModal';
	
	// $('#close').click(function(event)
	// {
	// 	event.preventDefault();
	// 	hideModal();
	// });

	$('#container').beforeAfter(
	{
		animateIntro : true,
		introDelay : 2000,
		introDuration : 500,
		showFullLinks : false
	});
});