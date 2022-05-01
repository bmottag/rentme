<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/rent_details.js"); ?>"></script>
<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
?>
		<script>
			$(function() {
				toastr.success('<?php echo $retornoExito ?>')
		  	});
		</script>
<?php
	}

	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
?>
		<script>
			$(function() {
				toastr.error('<?php echo $retornoError ?>')
		  	});
		</script>
<?php
	}
?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="btn-group btn-group-toggle">
							<a class="btn btn-default" href=" <?php echo base_url().'dashboard/super_admin'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
						</div>
					</div>
					<div class="card-body">
						<div class="alert alert-<?php echo $info[0]['clase']; ?>">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							Actual status: <strong><?php echo $info[0]['name_status']; ?></strong>
						</div>
				        <div class="invoice p-3 mb-3">
				          	<div class="row invoice-info">
					          	<div class="col-sm-4 invoice-col">
					              <address>
					                <strong>Client: </strong><?php echo $info[0]['param_client_name']; ?><br>
					                <strong>Beginning date: </strong><?php echo $info[0]['start_date']; ?><br>
					                <strong>It's clean ?: </strong><?php echo $info[0]['clean']==1?"Si":"No"; ?><br>
					                <strong>Type of contract: </strong><?php echo $info[0]['name_type_contract']; ?><br>
					              </address>
					            </div>
					            <div class="col-sm-4 invoice-col">
					              <address>
					                <strong>Type: </strong><?php echo $info[0]['type_2']; ?><br>
					                <strong>Finish_date: </strong><?php echo $info[0]['finish_date']; ?><br>
					                <strong>Does it have any damage ?: </strong><?php echo $info[0]['damage']==1?"Si":"No"; ?><br>
					                <strong>Current hours: </strong><?php echo $info[0]['current_hours']; ?><br>
					              </address>
					            </div>
					            <div class="col-sm-4 invoice-col">
					              <address>
					                <strong>Equipment: </strong><?php echo $info[0]['unit_number'] ?>---><?php echo $info[0]['description'] ?><br>
					                <strong>Current Fuel: </strong><?php echo $info[0]['fuel']; ?><br>
					                <?php if ($info[0]['damage']==1) { ?>
					                <strong>Damage observation: </strong><?php echo $info[0]['damage_observation']; ?><br>
					               	<?php } ?>
					                <strong>Observations: </strong><?php echo $info[0]['observations']; ?><br>
					              </address>
					            </div>
				          	</div>
						</div>
						<!--INICIO ADDITIONAL INFORMATION -->
						<div class="row">
							<div class="col-lg-6">
								<div class="panel panel-primary">
									<div class="alert alert-info">
										ADDITIONAL INFORMATION <br>
										This field is only additional information for the office.
									</div>
									<div class="panel-body">
										<div class="col-lg-12">
											<form name="formState" id="formState" class="form-horizontal" method="post">
												<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="state">Status :</label>
													<div class="col-sm-8">
														<select name="status" id="status" class="form-control">
															<option value="">Select...</option>
															<?php for ($i = 0; $i < count($status); $i++) { ?>
																<option value="<?php echo $status[$i]["id_status"]; ?>"><?php echo $status[$i]["name_status"]; ?></option>	
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="information">Additional information :</label>
													<div class="col-sm-8">
													<textarea id="information" name="information" class="form-control" rows="3" placeholder="Additional information"></textarea>
													</div>
												</div>
												<div class="form-group">
													<div class="row" align="center">
														<div style="width:100%;" align="center">
															<button type="button" id="btnState" name="btnState" class="btn btn-primary" >
																Save <span class="fa fa-save" aria-hidden="true" />
															</button> 
															
														</div>
													</div>
												</div>
											</form>
											<div class="alert alert-danger ">
												<span class="fa fa-exclamation-circle" aria-hidden="true"></span>
												Be sure you fild all the information.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">	
								<div class="chat-panel panel panel-primary">
									<div class="alert alert-info">
										<i class="fa fa-comments fa-fw"></i> Status history
									</div>
									<div class="panel-body">
										<ul class="chat">
										<?php 
											if($rentStatus)
											{
												foreach ($rentStatus as $data):
										?>
											<li class="right clearfix">
												<span class="chat-img pull-right">
													<small class="pull-right text-muted">
														<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['date_issue']; ?>
													</small>
												</span>
												<div class="chat-body clearfix">
													<div class="header">
														<span class="fa fa-user" aria-hidden="true"></span>
														<strong class="primary-font"><?php echo $data['first_name']; ?></strong>
													</div>
													<?php echo $data['observation']; ?>
													<?php echo '<p class="text-' . $data['clase'] . '"><strong><i class="fa ' . $data['icono'] . ' fa-fw"></i>' . $data['name_status'] . '</strong></p>'; ?>
												</div>
											</li>
										<?php
												endforeach;
											}
										?>
										</ul>
									</div>
								</div>
							</div>	
						</div>
						<!--FIN ADDITIONAL INFORMATION -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>