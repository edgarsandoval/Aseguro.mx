$(document).ready(function()
{
    $('#btn-cotizar').click(function(event)
    {
        event.preventDefault();
        cotizar();

        $('#btn-real').click();

        if(!valido())
            return;

        $('#loading-modal').modal();

    });
});

function valido()
{
    var ret = true;
    $('form :text').each(function()
    {
        if($.trim($(this).val()) == "" &&
           $.trim($(this).attr('name')) != 'user-phone' && 
           $.trim($(this).attr('name')) != 'contact-name' &&
           $.trim($(this).attr('name')) != 'contact-mail')
        {
            console.log($(this));
            ret = false;
            return;
        } 
    });

    if(!ret)
        return false;

    $('#frm-cotizar select').each(function()
    {
        if($.trim($(this).val()) == "" )
        {
            ret = false;
            return;
        } 
    });

    return ret;
}

function loadModels(){
    $("#model").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "models",
            type: 'POST',
            data: {
                'tipo': $("#vehicle-type").val()
            },
            success: function(result){
                $("#model").empty().append("<option selected disabled hidden value>Modelo:</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].Modelo);
                    $("#model").append("<option value='"+jsonObj[i].Modelo+"'>"+jsonObj[i].Modelo+"</option>")
                }
            }
        }
    );
}

function loadMarcas(){
    $("#trademark").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "marcas",
            type: 'POST',
            data: {
                'tipo': $("#vehicle-type").val(),
                'modelo': $("#model").val()
            },
            success: function(result){
                $("#trademark").empty().append("<option selected disabled hidden value>Marca:</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].Marca);
                    $("#trademark").append("<option value='"+jsonObj[i].IdMarca+"'>"+jsonObj[i].Marca+"</option>")
                }
            }
        }
    );
}

function loadSubMarcas(){
    $("#sub-trademark").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "submarcas",
            type: 'POST',
            data: {
                'tipo': $("#vehicle-type").val(),
                'modelo': $("#model").val(),
                'marca': $("#trademark").val(),
            },
            success: function(result){
                $("#sub-trademark").empty().append("<option selected disabled hidden value>Submarca:</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].ProductorSubGrupo);
                    $("#sub-trademark").append("<option value='"+jsonObj[i].IdProductorSubGrupo+"'>"+jsonObj[i].ProductorSubGrupo+"</option>")
                }
            }
        }
    );
}


function loadDescription(){
    $("#descripcion").empty().append("<option>-Cargando-</option>");
    $.ajax(
        {
            url: "descripcion",
            type: 'POST',
            data: {
                'tipo': $("#vehicle-type").val(),
                'modelo': $("#model").val(),
                'marca': $("#trademark").val(),
                'submarca': $("#sub-trademark").val(),
            },
            success: function(result){
                $("#description").empty().append("<option selected disabled hidden value>Descripción</option>");
                var jsonObj = $.parseJSON(result);
                for(var i in jsonObj)
                {
                    console.log(jsonObj[i].DescripcionAuto);
                    $("#description").append("<option value='"+jsonObj[i].ClaveInterna+"'>"+jsonObj[i].DescripcionAuto+"</option>")
                }
            }
        }
    );
}

function loadMunicipios(){
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

function loadCP(){
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

function cotizar(){
    //Validar

    var x = $("#user-year").val() + '/' + $("#user-month").val() + '/' + $("#user-day").val();

    var birthdate = new Date(x);
    var cur = new Date();
    var diff = cur-birthdate;
    var age = Math.floor(diff/31536000000);


    $('#user-age').val(age);


    $('#frm-cotizar').append($('<input type="hidden">').attr('name', 'marca').val($('#trademark option:selected').html()))
    $('#frm-cotizar').append($('<input type="hidden">').attr('name', 'sub-marca').val($('#sub-trademark option:selected').html()))

    //console.log($("#vehicle-type").val(), $("#model").val(), $("#description").val(),$("#cp").val(),genero, age);

    // Mandamos a llamar la funcion del controlador para mandar el formulario. 

    // $.ajax(
    //     {
    //         url: "cotizar",
    //         type: 'POST',
    //         data: {
    //             'tipo': $("#vehicle-type").val(),
    //             'modelo': $("#model").val(),
    //             'description':  $("#description").val(),
    //             'cp': $("#cp").val(),
    //             'genero': genero,
    //             'edad': age
    //         },
    //         success: function(result){
    //             alert("cotizado mira la consola --- Sandy que se debe de hacer aqui cual es diseño .... un mail o que");
    //             console.log(result);
    //         }
    //     }
    // );
}


