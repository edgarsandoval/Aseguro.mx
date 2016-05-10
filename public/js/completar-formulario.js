$(document).ready(function()
{
	$('.option-container').css('height', $('.form-body').height() / 3);
	$('.form-option').click(function()
	{
		$('.form-option').removeClass('selected');
		$(this).addClass('selected');
	});

    $('#btn-continuar').click(function()
    {
        var actual = parseInt($('#no-pag').val());
        var siguiente = actual + 1;

        $('.form-option').removeClass('selected');
        $($('div.col-md-2 .option-container .form-option')[siguiente - 1]).addClass('selected');

        if(siguiente == 3)
            $('#btn-continuar').hide();
        else
            $('#btn-continuar').show();

        for(var i = 1; i <= 3; i++)
            if(i == actual + 1)
                $('#form-page-' + siguiente).show();
            else
                $('#form-page-' + i).hide();

        $('#no-pag').val(siguiente);
    });

    $('.pago-opcion').click(function()
    {
    	$('.pago-opcion').removeClass('selected');
		$(this).addClass('selected');
    });

});

function setPage(number)
{
    $('.form-option').removeClass('selected');
    $($('div.col-md-2 .option-container .form-option')[number - 1]).addClass('selected');

    if(number == 3)
        $('#btn-continuar').hide();
    else
        $('#btn-continuar').show();
    
    var actual = $('#no-pag').val(number);    

    for(var i = 1; i <= 3; i++)
            if(i == number)
                $('#form-page-' + i).show();
            else
                $('#form-page-' + i).hide();
}


function setPayment(id)
{
	$('input[name="opcion"]').val(id);
}

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