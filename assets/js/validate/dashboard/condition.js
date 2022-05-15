$(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            return true;
        }
    });

    $("#clean").change(function () {
        if (this.value == 1) {
            $("#limpieza1").css({display: "block"});
            $("#limpieza2").css({display: "none"});
        } else if (this.value == 2) {
            $("#limpieza1").css({display: "none"});
            $("#limpieza2").css({display: "block"});
        } else {
            $("#limpieza1").css({display: "none"});
            $("#limpieza2").css({display: "none"});
        }
    });

    $("#damage").change(function () {
        if (this.value == 1) {
            $("#oculto").css({display: "block"});
        } else {
            $("#oculto").css({display: "none"});
        }
    });

    $('#form').validate({
        rules: {
            fuel:           { required: true },
            clean:          { required: true },
            damage:         { required: true }
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

    $("#btnSubmit").click(function() {
        var id = $('#hddId').val();
        if ($("#form").valid() == true){
            $('#btnSubmit').attr('disabled','-1');
            $("#div_error").css("display", "none");
            $("#div_load").css("display", "inline");
            $.ajax({
                type: "POST",
                url: base_url + "dashboard/update_currentCondition",
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
                    if( data.result )
                    {                                                         
                        $("#div_load").css("display", "none");
                        $('#btnSubmit').removeAttr('disabled');
                        var url = base_url + "dashboard/rent_details/" + id;
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
        }
    });
});