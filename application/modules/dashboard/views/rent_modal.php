<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/ajaxTrucks.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/rent.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Rent Form</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Los campos con * son obligatorios.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value='<?php echo $information?$information[0]["id_rent"]:'x'; ?>'/>
		<input type="hidden" id="last_message" name="last_message" value='<?php echo $information?$information[0]["last_message"]:'New Rent'; ?>'/>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="id_client">Client: *</label>
					<select name="id_client" id="id_client" class="form-control">
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($clientList); $i++) { ?>
							<option value="<?php echo $clientList[$i]["id_company"]; ?>" <?php if($information && $clientList[$i]["id_company"] == $information[0]['fk_id_client']) { echo "selected"; } ?>><?php echo $clientList[$i]["company_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="type">Type: *</label>
					<select name="type" id="type" class="form-control">
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($equipmentType); $i++) { ?>
							<option value="<?php echo $equipmentType[$i]["id_type_2"]; ?>" <?php if($information && $information[0]["type_level_2"] == $equipmentType[$i]["id_type_2"]) { echo "selected"; }  ?>><?php echo $equipmentType[$i]["type_2"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<div id="div_truck">
						<label for="truck">Equipment: *</label>
						<select name="truck" id="truck" class="form-control">
							<option value=''>Select...</option>
							<?php 
							foreach ($trucks as $fila) { ?>
								<option value="<?php echo $fila["id_truck"]; ?>" <?php if($information && $information[0]["fk_id_equipment"] == $fila["id_truck"]) { echo "selected"; }  ?>><?php echo $fila["unit_number"]; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row">	
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="start_date">Beginning date: *</label>
                    <div class="input-group date" id="start_date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="start_date" name="start_date" data-target="#start_date" value="<?php echo $information?$information[0]["start_date"]:""; ?>" placeholder="Beginning date"/>
                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="finish_date">Finish date: *</label>
                    <div class="input-group date" id="finish_date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="finish_date" name="finish_date" data-target="#finish_date" value="<?php echo $information?$information[0]["finish_date"]:""; ?>" placeholder="Finish date"/>
                        <div class="input-group-append" data-target="#finish_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="fuel">Current Fuel: *</label>
					<input id="fuel" name="fuel" placeholder="Current Fuel" class="form-control" value="<?php echo $information?$information[0]["fuel"]:""; ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="clean">It's clean ?: *</label>
					<select name="clean" id="clean" class="form-control">
						<option value=''>Select...</option>
						<option value='1' <?php if($information && $information[0]["clean"] == 1) { echo "selected"; } ?>>Si</option>
						<option value='2' <?php if($information && $information[0]["clean"] == 2) { echo "selected"; } ?>>No</option>
					</select>
				</div>
			</div>
		
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="damage">Does it have any damage ?: *</label>
					<select name="damage" id="damage" class="form-control">
						<option value=''>Select...</option>
						<option value='1' <?php if($information && $information[0]["damage"] == 1) { echo "selected"; } ?>>Si</option>
						<option value='2' <?php if($information && $information[0]["damage"] == 2) { echo "selected"; } ?>>No</option>
					</select>
				</div>
			</div>
		</div>
		<?php
		$oculto = 'style="display: none;"';
		if ($information && $information[0]["damage"] == 1){
			$oculto = '';
		}
		?>
		<div class="row" id="oculto" <?php echo $oculto; ?>>
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="damage_observation">Damage observation: </label>
					<textarea id="damage_observation" name="damage_observation" class="form-control" rows="2"><?php echo $information?$information[0]["damage_observation"]:""; ?></textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="type_contract">Type of contract: *</label>
					<select name="type_contract" id="type_contract" class="form-control">
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($contractType); $i++) { ?>
							<option value="<?php echo $contractType[$i]["id_type_contract"]; ?>" <?php if($information && $contractType[$i]["id_type_contract"] == $information[0]['fk_id_type_contract']) { echo "selected"; } ?>><?php echo $contractType[$i]["name_type_contract"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="current_hours">Current hours: *</label>
					<input id="current_hours" name="current_hours" placeholder="Current hours" class="form-control" value="<?php echo $information?$information[0]["current_hours"]:""; ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observations">Observations: *</label>
					<textarea id="observations" name="observations" class="form-control" rows="2"><?php echo $information?$information[0]["observations"]:""; ?></textarea>
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
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
		Guardar <span class="fa fa-save" aria-hidden="true">
	</button> 
</div>

<script>
  $(function () {
    //Date picker
    $('#start_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#finish_date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
   });
 </script>