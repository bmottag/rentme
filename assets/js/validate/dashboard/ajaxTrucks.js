/**
 * Trucks list by company
 * @author bmottag
 * @since  25/1/2017
 */

$(document).ready(function () {
	
    $('#type').change(function () {
    	$("#div_load").css("display", "none");
        $("#div_error").css("display", "none");
        $("#div_error2").css("display", "none");
        $('#type option:selected').each(function () {
			var type = $('#type').val();
			if (type > 0 || type != '') {
				if (type != 8) {
					$.ajax ({
						type: 'POST',
						url: base_url + 'dashboard/truckList',
						data: {'type': type},
						cache: false,
						success: function (data)
						{
							$('#truck').html(data);
						}
					});
					if(type == 3) {
						$("#div_standby").css("display", "inline");
					}else{
						$("#div_standby").css("display", "none");
					}
					$("#div_other").css("display", "none");
					$("#div_truck").css("display", "inline");
					$('#otherEquipment').val("");
					$('#truck').val("");
				} else {
					$("#div_other").css("display", "inline");
					$("#div_truck").css("display", "none");
					$('#otherEquipment').val("");
					$('#truck').val(5);
				}
			} else {
				var data = '';
				$('#truck').html(data);
			}
        });
    });

    $("#truck").change(function () {
        getRentVehicle();
    });
});

function getRentVehicle(){
    var equipment = $('#truck').val();
    if (equipment != '') {
        $.ajax({
            type: "POST", 
            url: base_url + "dashboard/alert_rentVehicle",
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
                        $("#div_error").css("display", "inline");
                        $("#span_msj").html(data.msj);
                    } else {
                        $("#div_load").css("display", "none");
                        $("#div_error").css("display", "none");
                    }
                }
                else
                {
                    alert('Error. Reload the web page.');
                    $("#div_load").css("display", "none");
                    $("#div_error").css("display", "inline");
                } 
            },
            error: function(result) {
                alert('Error. Reload the web page.');
                $("#div_load").css("display", "none");
                $("#div_error").css("display", "inline");
            }
        });
    } else {
    	$("#div_load").css("display", "none");
        $("#div_error").css("display", "none");
    }
}