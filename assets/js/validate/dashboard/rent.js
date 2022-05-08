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

    $("#truck").change(function () {
        getMaintenance();
    });

    $("#type_contract").change(function () {
        getMaintenance();
    });

    $("#current_hours").change(function () {
        getMaintenance();
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
            //cleaning_date:       { required: true },
            //next_cleaning_date:  { required: true },
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

    $("#btnSubmit").click(function() {
        if ($("#form").valid() == true){
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
                    if( data.result )
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
        }
    });
});

function getMaintenance(){
    var equipment = $('#truck').val();
    var type_contract = $('#type_contract').val();
    var current_hours = $('#current_hours').val();
    if (equipment != '' && type_contract != '' && current_hours != '') {
        $.ajax({
            type: "POST", 
            url: base_url + "dashboard/alert_maintenance",
            data: $("#form").serialize(),
            dataType: "json",
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            cache: false,
            success: function(data){
                if(data.result)
                {
                    if (data.bandera)
                    {
                        $("#div_load").css("display", "none");
                        $("#div_error2").css("display", "inline");
                        $("#span_msj2").html(data.msj2);
                    } else {
                        $("#div_load").css("display", "none");
                        $("#div_error2").css("display", "none");
                    }
                }
                else
                {
                    alert('Error. Reload the web page.');
                    $("#div_load").css("display", "none");
                    $("#div_error2").css("display", "inline");
                } 
            },
            error: function(result) {
                alert('Error. Reload the web page.');
                $("#div_load").css("display", "none");
                $("#div_error2").css("display", "inline");
            }
        });
    } else {
        $("#div_load").css("display", "none");
        $("#div_error2").css("display", "none");
    }
}