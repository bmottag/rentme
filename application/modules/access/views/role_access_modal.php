<script type="text/javascript" src="<?php echo base_url("assets/js/validate/access/role_access.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/access/ajaxAccessLinks.js"); ?>"></script>

<script>
$(function () {
	$('.select2').select2();
    $('#order').select2({
        dropdownParent: $('#modal')
    });
});
</script>

<div class="modal-header">
	<h4 class="modal-title">Role Access</h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_access"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="perfil">Menu name : *</label>
					<select name="id_menu" id="id_menu" class="form-control" required>
						<option value="">Select...</option>
						<?php for ($i = 0; $i < count($menuList); $i++) { ?>
							<option value="<?php echo $menuList[$i]["id_menu"]; ?>" <?php if($information && $information[0]["fk_id_menu"] == $menuList[$i]["id_menu"]) { echo "selected"; }  ?>><?php echo $menuList[$i]["menu_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		
<?php 
	$mostrar = "none";
	if($information && !IS_NULL($information[0]["fk_id_link"]) && $information[0]["fk_id_link"] > 0 && $linkList){
		$mostrar = "inline";
	}
?>
		
			<div class="col-sm-6" id="div_link" style="display:<?php echo $mostrar; ?>">
				<div class="form-group text-left">
					<label class="control-label" for="perfil">Link name : *</label>
					<select name="id_link" id="id_link" class="form-control" >
						<option value="">Select...</option>
						<?php 
						if($linkList){
							for ($i = 0; $i < count($linkList); $i++) { 
						?>
								<option value="<?php echo $linkList[$i]["id_link"]; ?>" <?php if($information && $information[0]["fk_id_link"] == $linkList[$i]["id_link"]) { echo "selected"; }  ?>><?php echo $linkList[$i]["link_name"]; ?></option>	
						<?php 
							} 
						}
						?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="id_rol">Role name : *</label>
					<select name="id_role" id="id_role" class="form-control" required>
						<option value="">Select...</option>
						<?php for ($i = 0; $i < count($roles); $i++) { ?>
							<option value="<?php echo $roles[$i]["id_role"]; ?>" <?php if($information && $information[0]["fk_id_role"] == $roles[$i]["id_role"]) { echo "selected"; }  ?>><?php echo $roles[$i]["role_name"]; ?></option>	
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