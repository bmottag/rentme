$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });
  $('#form').validate({
    rules: {
      menu_name:          { required: true, minlength: 3, maxlength:50 },
      menu_url:         { minlength: 4, maxlength:100 },
      order:            { required: true },
      menu_type:          { required: true },
      menu_status:         { required: true },
      menu_icon:          { required: true, minlength: 3, maxlength:50 }
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
          url: base_url + "access/save_menu", 
          data: $("#form").serialize(),
          dataType: "json",
          contentType: "application/x-www-form-urlencoded;charset=UTF-8",
          cache: false,
          
          success: function(data){
                                            
            if( data.result == "error" )
            {
              $("#div_load").css("display", "none");
              $('#btnSubmit').removeAttr('disabled');             
              return false;
            } 

            if( data.result )//true
            {                                                         
              $("#div_load").css("display", "none");
              $('#btnSubmit').removeAttr('disabled');

              var url = base_url + "access/menu";
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
