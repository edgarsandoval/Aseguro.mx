$(document).ready(function()
{
	if($('#background-home').height() == 40)
		location.reload(true);

	if(buscarMensaje())
	{
		var mensaje = $("#mensaje").val();

		$('#common-modal .modal-body > p').html(mensaje);
		$('#common-modal').modal();
	}
	else
		$("#home-modal").modal();


	$('#container').beforeAfter(
	{
		animateIntro : true,
		introDelay : 2000,
		introDuration : 500,
		showFullLinks : false
	});
});

function buscarMensaje()
{
	return $("#mensaje").val() != "null";
}