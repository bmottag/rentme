<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/job.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Job Form</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_job"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="idClient">Client: *</label>
					<?php 
						if(!$infoClients){
			               echo '<div class="col-lg-12">
			                    	<p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> Ask the manager to add Clients!</p>
			                  	</div>';
			                echo '<input id="idClient" name="idClient" type="hidden">';
						}else{
					?>
					<select name="idClient" id="idClient" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($infoClients); $i++) { ?>
							<option value="<?php echo $infoClients[$i]["id_param_client"]; ?>" <?php if($information && $infoClients[$i]["id_param_client"] == $information[0]['fk_id_param_client']) { echo "selected"; }  ?>><?php echo $infoClients[$i]["param_client_name"]; ?></option>	
						<?php } ?>
					</select>
					<?php 
						}
					?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="jobName">Job Code/Name: *</label>
					<input type="text" id="jobName" name="jobName" class="form-control" value="<?php echo $information?$information[0]["job_description"]:""; ?>" placeholder="Job Code/Name" required >
				</div>
			</div>
		</div>

<?php if($information){ ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="statusJob">Status: *</label>
					<select name="statusJob" id="statusJob" class="form-control" required>
						<option value=''>Select...</option>
						<option value='1' <?php if($information && $information[0]["status"] == '1') { echo "selected"; }  ?>>Active</option>
						<option value='2' <?php if($information && $information[0]["status"] == '2') { echo "selected"; }  ?>>Inactive</option>
					</select>
				</div>
			</div>
		</div>
<?php } ?>
					
		<div class="form-group">
			<div id="div_load" style="display:none">		
				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
						<span class="sr-only">45% completado</span>
					</div>
				</div>
			</div>
			<div id="div_error" style="display:none">			
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
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