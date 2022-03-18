<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/param_clients.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Clients Form</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_param_client"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="clientName">Client Name: *</label>
					<input type="text" id="clientName" name="clientName" class="form-control" value="<?php echo $information?$information[0]["param_client_name"]:""; ?>" placeholder="Client Name" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="contact">Contact: *</label>
					<input type="text" id="contact" name="contact" class="form-control" value="<?php echo $information?$information[0]["param_client_contact"]:""; ?>" placeholder="Contact" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Movil number: *</label>
					<input type="number" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["param_client_movil"]:""; ?>" placeholder="Movil number" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Email: *</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["param_client_email"]:""; ?>" placeholder="Email" />
				</div>
			</div>
		</div>
				
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="address">Address:</label>
					<input type="text" class="form-control" id="address" name="address" value="<?php echo $information?$information[0]["param_client_address"]:""; ?>" placeholder="Address" />
				</div>
			</div>

	<?php if($information){ ?>
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="status">Status: *</label>
					<select name="status" id="status" class="form-control" required>
						<option value=''>Seleccione...</option>
						<option value=1 <?php if($information[0]["param_client_status"] == 1) { echo "selected"; }  ?>>Active</option>
						<option value=2 <?php if($information[0]["param_client_status"] == 2) { echo "selected"; }  ?>>Inactive</option>
					</select>
				</div>
			</div>
	<?php } ?>
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
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<div id="span_msj"></div>
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