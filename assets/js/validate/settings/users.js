$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });

  $("#firstName").bloquearNumeros().maxlength(25);
  $("#lastName").bloquearNumeros().maxlength(25);   
  $("#movilNumber").bloquearTexto().maxlength(10);
  $("#firstName").convertirMayuscula();
  $("#lastName").convertirMayuscula();
  $('#form').validate({
    rules: {
      firstName:      { required: true, minlength: 3, maxlength:25 },
      lastName:       { required: true, minlength: 3, maxlength:25 },
      user:         { required: true, minlength: 4, maxlength:15 },
      email:        { required: true, email: true, minlength: 6, maxlength:50 },
      movilNumber:    { required: true, minlength: 10, maxlength:10 },
      id_role:      { required: true }
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
          url: base_url + "settings/save_user", 
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

              var url = base_url + "settings/users/" + data.status;
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
