<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/tax.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Taxes</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Fields with * are required.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_param_company_taxes"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="taxes_description">Tax Description: *</label>
					<input type="text" id="taxes_description" name="taxes_description" class="form-control" value="<?php echo $information?$information[0]["taxes_description"]:""; ?>" placeholder="Tax Description" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="taxes_value">Tax Value: *</label>
					<input type="number" id="taxes_value" name="taxes_value" class="form-control" value="<?php echo $information?$information[0]["taxes_value"]:""; ?>" placeholder="Tax Value" min="1" max="25" required >
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