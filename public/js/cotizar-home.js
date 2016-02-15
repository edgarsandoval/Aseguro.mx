function procesarBanco(button)
{
	var id = button.id;
	id = id.slice(3, id.length);

	$.ajax(
		{
			url : 'pagarBanco',
			type : 'POST',
			data : {	
				'id' : id,
				'monto' : $('#txt' + id).val()
			},
			success : function(result)
			{
				//
			}

		});
}

	// $.ajax(
	//         {
	//             url: "models",
	//             type: 'POST',
	//             data: {
	//                 'tipo': $("#vehicle-type").val()
	//             },
	//             success: function(result){
	//                 $("#model").empty().append("<option selected disabled hidden value>Modelo:</option>");
	//                 var jsonObj = $.parseJSON(result);
	//                 for(var i in jsonObj)
	//                 {
	//                     console.log(jsonObj[i].Modelo);
	//                     $("#model").append("<option value='"+jsonObj[i].Modelo+"'>"+jsonObj[i].Modelo+"</option>")
	//                 }
	//             }
	//         }
	//     );