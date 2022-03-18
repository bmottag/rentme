$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });

  $("#companyName").bloquearNumeros().maxlength(60);
  $("#contact").bloquearNumeros().maxlength(60);   
  $("#movilNumber").bloquearTexto().maxlength(10);
  $("#contact").convertirMayuscula();
  $('#form').validate({
    rules: {
      companyName:     { required: true, minlength: 3, maxlength:60 },
      contact:        { required: true, minlength: 3, maxlength:60 },
      movilNumber:    { required: true, minlength: 10, maxlength:10 },
      gst:            { minlength: 5, maxlength:12 },
      idCountry:      { required: true },
      idCity:         { required: true }
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

  $("#btnSubmit").click(function(){   
  
    if ($("#form").valid() == true){
    
        //Activa icono guardando
        $('#btnSubmit').attr('disabled','-1');
        $("#div_error").css("display", "none");
        $("#div_load").css("display", "inline");
      
        $.ajax({
          type: "POST", 
          url: base_url + "settings/update_company", 
          data: $("#form").serialize(),
          dataType: "json",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          cache: false,
          
          success: function(data){
                                            
            if( data.result == "error" )
            {
              $("#div_load").css("display", "none");
              $("#div_error").css("display", "inline");
              $("#span_msj").html(data.mensaje);
              $('#btnSubmit').removeAttr('disabled');             
              return false;
            } 

            if( data.result )//true
            {                                                         
              $("#div_load").css("display", "none");
              $('#btnSubmit').removeAttr('disabled');

              var url = base_url + "settings/company";
              $(location).attr("href", url);
            }
            else
            {
              alert('Error. Reload the web page.');
              $("#div_load").css("display", "none");
              $("#div_error").css("display", "inline");
              $('#btnSubmit').removeAttr('disabled');
            } 
          },
          error: function(result) {
            alert('Error. Reload the web page.');
            $("#div_load").css("display", "none");
            $("#div_error").css("display", "inline");
            $('#btnSubmit').removeAttr('disabled');
          }
        }); 
    }//if     
  });
});
