$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });

  jQuery.validator.addMethod("validarFechaContrato", function(value, element, param) {
  var tipoVinculacion = $('#tipoVinculacion').val();
  if(tipoVinculacion==2 && value == ""){
    return false;
  }else{
    return true;
  }
}, "Este campo es requerido.");

  $("#nombreCompleto").bloquearNumeros().maxlength(100); 
  $("#username").bloquearNumeros().maxlength(20);
  $('#form').validate({
    rules: {
      nombreCompleto:     { required: true, minlength: 3, maxlength:100 },
      email:              { required: true, email: true, minlength: 6, maxlength:50 },
      username:           { required: true, minlength: 4, maxlength:20 },
      tipoVinculacion:    { required: true},
      estado:             { required: true },
      fechaFinContrato:   { validarFechaContrato: "#tipoVinculacion" },
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
          url: base_url + "users/save_intranet_user", 
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

              var url = base_url + "users/intranet_users/" + data.estado;
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