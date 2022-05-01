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
					                <strong>Current equipment condition: </strong><?php echo $info[0]['clean']==1?"Clean":"To be clean"; ?><br>
					                <strong>Type of rent : </strong><?php echo $info[0]['name_type_contract']; ?>
					                <p class="text-primary"><strong>From: </strong><?php echo $info[0]['start_date']; ?></p>
					              </address>
					            </div>
					            <div class="col-sm-4 invoice-col">
					              <address>
					                <strong>Type of equipment: </strong><?php echo $info[0]['type_2']; ?><br>
					                <strong>Does the unit has any damage(s)?: </strong><?php echo $info[0]['damage']==1?"Si":"No"; ?><br>
					                <strong>Current unit hours: </strong><?php echo $info[0]['current_hours']; ?><br>
					                <p class="text-primary"><strong>Until: </strong><?php echo $info[0]['finish_date']; ?></p>
					              </address>
					            </div>
					            <div class="col-sm-4 invoice-col">
					              <address>
					                <strong>Equipment: </strong><?php echo $info[0]['unit_number'] ?>---><?php echo $info[0]['description'] ?><br>
					                <strong>Current Fuel: </strong>
					                <?php 
									switch ($info[0]['fuel']) {
										case 1:
											echo "Empty"; 
											break;
										case 2:
											echo "1/4"; 
											break;
										case 3:
											echo"1/2"; 
											break;
										case 4:
											echo "3/4"; 
											break;
										case 5:
											echo "Full"; 
											break;
									}
					                ?>
					                <br>
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
							<div class="col-md-4">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title">Additional Information</h3>
									</div>
									<form name="formState" id="formState" class="form-horizontal" method="post">
										<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
										<div class="card-body">
											<div class="form-group">
												<label for="status">Status: </label>
												<select name="status" id="status" class="form-control">
													<option value="">Select...</option>
													<?php for ($i = 0; $i < count($status); $i++) { ?>
														<option value="<?php echo $status[$i]["id_status"]; ?>"><?php echo $status[$i]["name_status"]; ?></option>	
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<textarea id="information" name="information" class="form-control" rows="3" placeholder="Additional information"></textarea>
											</div>
										</div>
										<div class="card-footer">
											<button type="button" id="btnState" name="btnState" class="btn btn-primary" >
												Save <span class="fa fa-save" aria-hidden="true" />
											</button> 
										</div>
									</form>
								</div>
							</div>

							<div class="col-md-8">
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title"><i class="fa fa-comments fa-fw"></i> Status History</h3>
									</div>
									<div class="card-body">
										<table class="table">
											<tbody>
										<?php 
											if($rentStatus)
											{
												foreach ($rentStatus as $data):
											?>

												<tr>
													<td class="pull-right text-muted small" style="width: 20%">
														<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['date_issue']; ?>
													</td>
													<td class="small" style="width: 15%">
														<b><?php echo $data['first_name']; ?></b>
													</td>
													<td class="small" style="width: 50%">
														<?php echo $data['observation']; ?>
													</td>
													<td style="width: 15%">
														<small class="badge badge-<?php echo $data['clase']; ?>">
															<i class="fa <?php echo $data['icono']; ?>"></i>
															<?php echo $data['name_status']; ?>
														</small>
													</td>
												</tr>
										<?php
												endforeach;
											}
										?>
											</tbody>
										</table>
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