$( document ).ready( function () {
			
	$( "#formState" ).validate( {
		rules: {
			status:			{ required: true },
			information:	{ required: true }
		},
		errorElement: 'span',
	    errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
	    },
	    highlight: function (element, errorClass, validClass) {
	    	$(element).addClass('is-invalid');
	    },
	    unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
	    }
	});
	
	$("#btnState").click(function(){	
		var idRent = $('#hddId').val();
		if ($("#formState").valid() == true){
			$('#btnState').attr('disabled','-1');
			$.ajax({
				type: "POST",
				url: base_url + "dashboard/save_rent_status/" + idRent,	
				data: $("#formState").serialize(),
				dataType: "json",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					if( data.result == "error" )
					{
						$("#div_cargando").css("display", "none");
						$('#btnState').removeAttr('disabled');
						$("#span_msj").html(data.mensaje);
						$("#div_msj").css("display", "inline");
						return false;
					} 
					if( data.result )
					{	                                                        
						$("#div_cargando").css("display", "none");
						$("#div_guardado").css("display", "inline");
						$('#btnState').removeAttr('disabled');
						var url = base_url + "dashboard/rent_details/" + idRent;
						$(location).attr("href", url);
					}
					else
					{
						alert('Error. Reload the web page.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnState').removeAttr('disabled');
					}	
				},
				error: function(result) {
					alert('Error. Reload the web page.');
					$("#div_cargando").css("display", "none");
					$("#div_error").css("display", "inline");
					$('#btnState').removeAttr('disabled');
				}
			});
		}		
	});

	$( "#formAttachement" ).validate( {
		rules: {
			attachement:			{ required: true }
		},
		errorElement: 'span',
	    errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
	    },
	    highlight: function (element, errorClass, validClass) {
	    	$(element).addClass('is-invalid');
	    },
	    unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
	    }
	});
	
	$("#btnAttachement").click(function(){	
		var idRent = $('#hddId').val();
		if ($("#formAttachement").valid() == true){
			$('#btnAttachement').attr('disabled','-1');
			$.ajax({
				type: "POST",
				url: base_url + "dashboard/save_attachement",	
				data: $("#formAttachement").serialize(),
				dataType: "json",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				cache: false,
				success: function(data){
					if( data.result == "error" )
					{
						$("#div_cargando").css("display", "none");
						$('#btnAttachement').removeAttr('disabled');
						$("#span_msj").html(data.mensaje);
						$("#div_msj").css("display", "inline");
						return false;
					} 
					if( data.result )
					{	                                                        
						$("#div_cargando").css("display", "none");
						$("#div_guardado").css("display", "inline");
						$('#btnAttachement').removeAttr('disabled');
						var url = base_url + "dashboard/rent_details/" + idRent;
						$(location).attr("href", url);
					}
					else
					{
						alert('Error. Reload the web page.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnAttachement').removeAttr('disabled');
					}	
				},
				error: function(result) {
					alert('Error. Reload the web page.');
					$("#div_cargando").css("display", "none");
					$("#div_error").css("display", "inline");
					$('#btnAttachement').removeAttr('disabled');
				}
			});
		}		
	});


});