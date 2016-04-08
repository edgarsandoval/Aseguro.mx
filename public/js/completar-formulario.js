$(document).ready(function()
{
	$('.option-container').css('height', $('.form-body').height() / 3);
	$('.form-option').click(function()
	{
		$('.form-option').removeClass('selected');
		$(this).addClass('selected');
	});
});

function loadMunicipios()
{
    $("#municipios").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "municipios",
            type: 'POST',
            data: {
                'estado': $("#estados").val()
            },
            success: function(result){
                $("#municipios").empty().append("<option selected disabled hidden value>Municipios:</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].MunicipioNombre);
                    $("#municipios").append("<option value='"+jsonObj[i].Municipio+"'>"+jsonObj[i].MunicipioNombre+"</option>")
                }
            }
        }
    );
}

function loadCP()
{
    $("#cp").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "cp",
            type: 'POST',
            data: {
                'municipio': $("#municipios").val()
            },
            success: function(result){
                $("#cp").empty().append("<option selected disabled hidden value>CP:</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].CP);
                    $("#cp").append("<option value='"+jsonObj[i].CP+"'>"+jsonObj[i].CP+"</option>")
                }
            }
        }
    );
}