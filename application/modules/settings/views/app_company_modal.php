<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/app_company.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/access/ajaxCities.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Company Information</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_company"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="companyName">Company Name: *</label>
					<input type="text" id="companyName" name="companyName" class="form-control" value="<?php echo $information?$information[0]["company_name"]:""; ?>" placeholder="Company Name" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="contact">Contact: *</label>
					<input type="text" id="contact" name="contact" class="form-control" value="<?php echo $information?$information[0]["company_contact"]:""; ?>" placeholder="Contact" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Movil number: *</label>
					<input type="number" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["company_movil"]:""; ?>" placeholder="Movil number" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="address">GST Number:</label>
					<input type="text" class="form-control" id="gst" name="gst" value="<?php echo $information?$information[0]["company_gst"]:""; ?>" placeholder="GST Number" />
				</div>
			</div>
		</div>
				
		<div class="row">


			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="address">Address:</label>
					<input type="text" class="form-control" id="address" name="address" value="<?php echo $information?$information[0]["company_address"]:""; ?>" placeholder="Address" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="idCountry">Country: *</label>
					<select name="idCountry" id="idCountry" class="form-control" required>
						<option value="">Select...</option>
						<?php for ($i = 0; $i < count($infoCountries); $i++) { ?>
							<option value="<?php echo $infoCountries[$i]["id_country"]; ?>" <?php if($information && $information[0]["fk_id_contry"] == $infoCountries[$i]["id_country"]) { echo "selected"; }  ?>><?php echo $infoCountries[$i]["country"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>

<?php 
	$mostrar = "none";
	if($information && !IS_NULL($information[0]["fk_id_city"]) && $information[0]["fk_id_city"] > 0 && $citiesList){
		$mostrar = "inline";
	}
?>

			<div class="col-sm-6" id="div_city" style="display:<?php echo $mostrar; ?>">
				<div class="form-group text-left">
					<label class="control-label" for="idCity">City: *</label>
					<select name="idCity" id="idCity" class="form-control" required>
						<option value="">Select...</option>
						<?php for ($i = 0; $i < count($citiesList); $i++) { ?>
							<option value="<?php echo $citiesList[$i]["id_city"]; ?>" <?php if($information && $information[0]["fk_id_city"] == $citiesList[$i]["id_city"]) { echo "selected"; }  ?>><?php echo $citiesList[$i]["city"]; ?></option>	
						<?php } ?>
					</select>
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