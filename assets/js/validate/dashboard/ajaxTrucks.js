/**
 * Trucks´list by company
 * @author bmottag
 * @since  25/1/2017
 */

$(document).ready(function () {
	
    $('#type').change(function () {
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
				}else{
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
	
    $('#standby').change(function () {
        $('#standby option:selected').each(function () {

			var standby = $('#standby').val();

			if (standby > 0 || standby != '') {
				if (standby == 1) {
					$("#div_operated").css("display", "none");
					$('#operatedby').val("");
				}else{
					$("#div_operated").css("display", "inline");
				}
			}

        });
    });
    
});