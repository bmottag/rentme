<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/condition.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Current Condition Form</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post">
		<input type="hidden" id="hddId" name="hddId" value='<?php echo $info[0]["id_rent"]; ?>'/>
		<input type="hidden" id="last_message" name="last_message" value='<?php echo $info?$info[0]["last_message"]:''; ?>'/>
		<div class="row">
			<div class="col-sm-12">
				<strong class="text-primary">Client: </strong><?php echo $info[0]['param_client_name']; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<strong>Type of equipment: </strong><?php echo $info[0]['type_2']; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<strong>Equipment: </strong><?php echo $info[0]['unit_number'] ?>---><?php echo $info[0]['description'] ?>
			</div>
		</div><br>
		<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="fuel">Current Fuel: *</label>
					<select name="fuel" id="fuel" class="form-control">
						<option value=''>Select...</option>
						<?php
						foreach ($currentFuelList as $fila) { ?>
							<option value="<?php echo $fila["param_value"]; ?>" <?php if(!empty($info[0]["fk_id_fuel"]) && $info[0]["fk_id_fuel"] == $fila["param_value"]) { echo "selected"; }  ?>><?php echo $fila["param_description"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="clean">Current equipment condition: *</label>
					<select name="clean" id="clean" class="form-control">
						<option value=''>Select...</option>
						<option value='1' <?php if($info && $info[0]["clean"] == 1) { echo "selected"; } ?>>Clean</option>
						<option value='2' <?php if($info && $info[0]["clean"] == 2) { echo "selected"; } ?>>To be clean</option>
					</select>
				</div>
			</div>

			<?php
			$limpieza1 = 'style="display: none;"';
			$limpieza2 = 'style="display: none;"';
			if ($info && $info[0]["clean"] == 1){
				$limpieza1 = 'style="display: block;"';
			}
			if ($info && $info[0]["clean"] == 2){
				$limpieza2 = 'style="display: block;"';
			}
			?>
			<div class="col-sm-4" id="limpieza1" <?php echo $limpieza1; ?>>
				<div class="form-group text-left">
					<label class="control-label" for="cleaning_date">Cleaning date: </label>
					<div class="input-group date" id="cleaning_date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="cleaning_date" name="cleaning_date" data-target="#cleaning_date" value="<?php echo $info?$info[0]["cleaning_date"]:""; ?>" placeholder="Cleaning date"/>
                        <div class="input-group-append" data-target="#cleaning_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>

			<div class="col-sm-4" id="limpieza2" <?php echo $limpieza2; ?>>
				<div class="form-group text-left">
					<label class="control-label" for="next_cleaning_date">Next cleaning date: </label>
					<div class="input-group date" id="next_cleaning_date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="next_cleaning_date" name="next_cleaning_date" data-target="#next_cleaning_date" value="<?php echo $info?$info[0]["next_cleaning_date"]:""; ?>" placeholder="Next cleaning date"/>
                        <div class="input-group-append" data-target="#next_cleaning_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="damage">Does the unit has any damage?: *</label>
					<select name="damage" id="damage" class="form-control">
						<option value=''>Select...</option>
						<option value='1' <?php if($info && $info[0]["damage"] == 1) { echo "selected"; } ?>>Yes</option>
						<option value='2' <?php if($info && $info[0]["damage"] == 2) { echo "selected"; } ?>>No</option>
					</select>
				</div>
			</div>
		</div>
		<?php
		$oculto = 'style="display: none;"';
		if ($info && $info[0]["damage"] == 1){
			$oculto = '';
		}
		?>
		<div class="row" id="oculto" <?php echo $oculto; ?>>
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="damage_observation">Damage observation: </label>
					<textarea id="damage_observation" name="damage_observation" class="form-control" rows="2"><?php echo $info?$info[0]["damage_observation"]:""; ?></textarea>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div id="div_load" style="display:none">		
				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
						<span class="sr-only">45% completado</span>
					</div>
				</div>
			</div>
			<div id="div_error" style="display:none">
				<div class="alert alert-danger alert-dismissible">
					<div id="span_msj"></div>
				</div>
			</div>
			<div id="div_error2" style="display:none">
				<div class="alert alert-danger alert-dismissible">
					<div id="span_msj2"></div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal-footer justify-content-between">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
		Save <span class="fa fa-save" aria-hidden="true">
	</button> 
</div>

<script>
  $(function () {
    //Date picker
    $('#cleaning_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#next_cleaning_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
   });
 </script>