$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });

  $("#invoiceNumber").bloquearTexto().maxlength(12);

  $("#damage").change(function () {
    if (this.value == 1) {
      $("#oculto").css({display: "block"});
    } else {
      $("#oculto").css({display: "none"});
    }
  });

  $('#form').validate({
    rules: {
      id_client:           { required: true },
      type:                { required: true },
      truck:               { required: true },
      start_date:          { required: true },
      finish_date:         { required: true },
      fuel:                { required: true },
      clean:               { required: true },
      damage:              { required: true },
      //damage_observation:  { required: true },
      type_contract:       { required: true },
      current_hours:       { required: true },
      observations:        { required: true }
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
          url: base_url + "dashboard/save_rent",
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
              var url = base_url + "dashboard/super_admin";
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