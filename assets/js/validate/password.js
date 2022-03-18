$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      return true;
    }
  });
  $('#form').validate({
    rules: {
		inputPassword: 		{ required: true, minlength: 6, maxlength:15 },
		inputConfirm: 		{ required: true, minlength: 6, maxlength:15, equalTo: "#inputPassword" }
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
			var form = document.getElementById('form');
			form.submit();	
		}else
		{
			//alert('Error.');
		}
	});
});