<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/rent.js"); ?>"></script>

<div class="modal-header">
	<h4 class="modal-title">Rent Form </h4>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	<p class="text-danger"><small><i class="icon fa fa-exclamation-triangle"></i> Los campos con * son obligatorios.</small></p>
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_catalogo_sistema"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="id_client">Client: *</label>
					<select name="id_client" id="id_client" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($clientList); $i++) { ?>
							<option value="<?php echo $clientList[$i]["id_company"]; ?>" <?php if($information && $clientList[$i]["id_company"] == $information[0]['fk_id_client']) { echo "selected"; }  ?>><?php echo $clientList[$i]["company_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="id_client">Client: *</label>
					<select name="id_client" id="id_client" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($clientList); $i++) { ?>
							<option value="<?php echo $clientList[$i]["id_company"]; ?>" <?php if($information && $clientList[$i]["id_company"] == $information[0]['fk_id_client']) { echo "selected"; }  ?>><?php echo $clientList[$i]["company_name"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">	
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Beginning date: *</label>
                    <div class="input-group date" id="vencimientoSoporte" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="fechaVencimiento" name="fechaVencimiento" data-target="#vencimientoSoporte" value="<?php echo $information?$information[0]["fecha_vencimiento_soporte"]:""; ?>" placeholder="Fecha Vencimiento Soporte" required/>
                        <div class="input-group-append" data-target="#vencimientoSoporte" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
				</div>
			</div>


		</div>



		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observaciones">Observation: </label>
					<textarea id="observaciones" name="observaciones" placeholder="Descripción" class="form-control" rows="2" ><?php echo $information?$information[0]["observaciones"]:""; ?></textarea>
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
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
		Guardar <span class="fa fa-save" aria-hidden="true">
	</button> 
</div>

<script>
  $(function () {
    //Date picker
    $('#vencimientoSoporte').datetimepicker({
        format: 'YYYY-MM-DD'
    });
   });
 </script>