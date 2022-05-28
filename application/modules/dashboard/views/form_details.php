<script type="text/javascript" src="<?php echo base_url("assets/js/validate/dashboard/rent_details.js"); ?>"></script>

<script>
$(function(){ 
	$("#<?php echo $info[0]["id_rent"]; ?>").click(function () {	
		var oID = $(this).attr("id");
    $.ajax ({
        type: 'POST',
				url: base_url + 'dashboard/cargarModalCondition',
        data: {'idRent': oID},
        cache: false,
        success: function (data) {
            $('#datosCondition').html(data);
        }
    });
	});	
});
</script>

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
		        <div class="invoice p-3 mb-3">
	          	<div class="row invoice-info">
		          	<div class="col-sm-4 invoice-col">
		              <address>
		                <strong>Client: </strong><?php echo $info[0]['param_client_name']; ?><br>
										<?php								
										$movil = $info[0]["param_client_movil"];
										// Separa en grupos de tres 
										$count = strlen($movil);
										$num_tlf1 = substr($movil, 0, 3); 
										$num_tlf2 = substr($movil, 3, 3); 
										$num_tlf3 = substr($movil, 6, 2); 
										$num_tlf4 = substr($movil, -2); 
										if($count == 10){
											$resultado = "$num_tlf1 $num_tlf2 $num_tlf3 $num_tlf4";  
										}else{
											
											$resultado = chunk_split($movil,3," ");
										}
										?>
		                <strong>Movil Number: </strong><?php echo $resultado; ?>
										<a href='<?php echo base_url("external/sendSMSClient/" . $info[0]["id_rent"]); ?>' class='btn btn-info btn-xs' title="Send SMS to Client"><i class='fa fa-paper-plane'></i> Send link to the client</a>
		                <br><br>
		                <strong>Current equipment condition: </strong><?php if ($info[0]['clean'] == 1) { ?> Clean <?php } else if ($info[0]['clean'] == 2) { ?> To be clean <?php } else { ?> <?php } ?><br>
		                <strong>Type of rent: </strong><?php echo $info[0]['name_type_contract']; ?>
		                <p class="text-<?php echo $info[0]['clase']; ?>"><strong>Actual status: </strong><?php echo $info[0]['name_status']; ?></p>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" id="<?php echo $info[0]["id_rent"] ?>">
											Current Condition <span class="fa fa-edit" aria-hidden="true"></span> 
										</button>
		              </address>
		            </div>
		            <div class="col-sm-4 invoice-col">
		              <address>
		                <strong>Type of equipment: </strong><?php echo $info[0]['type_2']; ?><br>
		                <strong>Equipment: </strong><?php echo $info[0]['unit_number'] ?>---><?php echo $info[0]['description'] ?><br><br>
		                <p class="text-primary">
		                		<strong>From: </strong><?php echo $info[0]['start_date']; ?></br>
												<strong>Until: </strong><?php echo $info[0]['finish_date']; ?>
										</p>
		              </address>
		            </div>
		            <div class="col-sm-4 invoice-col">
		              <address>
		                <strong>Current unit hours: </strong><?php echo $info[0]['current_hours']; ?><br>
		                <strong>Current Fuel: </strong><?php echo $info[0]['param_description']!=''?$info[0]['param_description']:''; ?><br><br>
		                <strong>Does the unit has any damage?: </strong><?php if ($info[0]['damage'] == 1) { ?> Si <?php } else if ($info[0]['damage'] == 2) { ?> No <?php } else { ?> <?php } ?><br>
		                <?php if ($info[0]['damage']==1) { ?>
		                <strong>Damage observation: </strong><?php echo $info[0]['damage_observation']; ?><br>
		               	<?php } ?>
		                <strong>Observations: </strong><?php echo $info[0]['observations']; ?>
		              </address>
		            </div>
	          	</div>
						</div>
					</div>
				</div>
			</div>
		</div>

    <div class="row">
			<section class="col-lg-6 connectedSortable">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Additional Information</h3>
					</div>
					<div class="card-body">
						<form name="formState" id="formState" method="post">
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-3 input-group input-group-sm">
										<select name="status" id="status" class="form-control">
											<option value="">Select Status...</option>
											<?php for ($i = 0; $i < count($status); $i++) { ?>
												<option value="<?php echo $status[$i]["id_status"]; ?>"><?php echo $status[$i]["name_status"]; ?></option>	
											<?php } ?>
										</select>
									</div>
									<div class="col-6 input-group input-group-sm">
											<input type="text" id="information" name="information"placeholder="Additional information" class="form-control">
									</div>
									<div class="col-3">
										<button type="button" id="btnState" name="btnState" class="btn btn-primary btn-sm" >
											Add Info <span class="fa fa-save" aria-hidden="true" />
										</button> 
									</div>
								</div>
							</div>
						</form>
						<?php 
							if($rentStatus)
							{
						?>
						<div class="direct-chat-messages">
							<table class="table">
								<thead>
									<tr class="small">
										<th class='text-center' style="width: 25%">Datetime</th>
										<th style="width: 25%">User</th>
										<th style="width: 30%">Additional Information</th>
										<th class='text-center' style="width: 20%">Status</th>
									</tr>
								</thead>
								<tbody>
								<?php
									foreach ($rentStatus as $data):
								?>
									<tr>
										<td class="text-muted small" style="width: 20%">
											<i class="fa fa-clock-o fa-fw"></i> <?php echo $data['date_issue']; ?>
										</td>
										<td class="small" style="width: 15%">
											<b><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></b>
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
								?>
								</tbody>
							</table>
						</div>
						<?php
							}
						?>
					</div>
				</div>
			</section>

			<section class="col-lg-6 connectedSortable">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Current Condition</h3>
					</div>
					<div class="card-body">
						<?php 
							//if($rentHistorical)
							//{
						?>
						<div class="direct-chat-messages">
							<table class="table">
								<thead>
									<tr class="small">
										<th style="width: 10%">Datetime</th>
										<th style="width: 10%">Hours</th>
										<th style="width: 10%">Fuel</th>
										<th style="width: 10%">Clean</th>
										<th style="width: 10%">Contract</th>
										<th class='text-center' style="width: 10%">From</th>
										<th class='text-center' style="width: 10%">Until</th>
										<th style="width: 10%">Damage</th>
										<th style="width: 10%">Responsible</th>
										<th style="width: 10%">Observations</th>
									</tr>
								</thead>
								<tbody>
								<?php
									foreach ($rentHistorical as $data):
								?>
									<tr>
										<td class="small" style="width: 10%">
											<?php echo $data['date_issue']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['current_hours']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['param_description']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php if ($data['clean'] == 1) { ?> Clean <?php } else if ($data['clean'] == 2) { ?> To be clean <?php } else { ?> <?php } ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['name_type_contract']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['start_date']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['finish_date']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php if ($data['damage'] == 1) { ?> Si <?php } else if ($data['damage'] == 2) { ?> No <?php } else { ?> <?php } ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['name']; ?>
										</td>
										<td class="small" style="width: 10%">
											<?php echo $data['observations']; ?>
										</td>
									</tr>
								<?php
									endforeach;
								?>
								</tbody>
							</table>
						</div>
						<?php
							//}
						?>
					</div>
				</div>
			</section>
		</div>

		<div class="row">
			<section class="col-lg-6 connectedSortable">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Attachements</h3>
					</div>
					<div class="card-body">
						<form name="formAttachement" id="formAttachement" method="post">
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-4 input-group input-group-sm">
										<select name="attachement" id="attachement" class="form-control">
											<option value=''>Select...</option>
											<?php 
											foreach ($attachementList as $fila) { ?>
												<option value="<?php echo $fila["param_value"]; ?>"><?php echo $fila["param_description"]; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-6 input-group input-group-sm">
											<input type="text" id="attachement_description" name="attachement_description"placeholder="More Info" class="form-control">
									</div>
									<div class="col-2">
										<button type="button" id="btnAttachement" name="btnAttachement	" class="btn btn-success btn-sm" >
											Add <span class="fa fa-save" aria-hidden="true" />
										</button> 
									</div>
								</div>
							</div>
						</form>
						<?php 
							if($rentAttachement)
							{
						?>
						<div class="direct-chat-messages">
							<table class="table">
								<thead>
									<tr class="small">
										<th class='text-center' style="width: 5%">#</th>
										<th style="width: 45%">Attachement</th>
										<th style="width: 30%">More Info</th>
										<th class='text-center' style="width: 20%">Date</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$i = 0;
									foreach ($rentAttachement as $data):
										$i++;
								?>
									<tr>
										<td class="text-center small">
											 <?php echo $i; ?>
										</td>
										<td class="small">
											<?php echo $data['type']; ?>
										</td>
										<td class="small">
											<?php echo $data['attachement_description']; ?>
										</td>
										<td class="text-center small">
											<?php echo $data['date']; ?>
										</td>
									</tr>
								<?php
									endforeach;
								?>
								</tbody>
							</table>
						</div>
						<?php
							}
						?>
					</div>
				</div>
			</section>

			<section class="col-lg-6 connectedSortable">
				<div class="card card-yellow">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Photographic Record</h3>
					</div>
					<div class="card-body">
						<form name="formPhotos" id="formPhotos" method="post" enctype="multipart/form-data" action="<?php echo base_url("dashboard/do_upload_photos"); ?>">
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-3 input-group input-group-sm">
										<select name="type" id="type" class="form-control">
											<option value="">Select Type...</option>
											<?php for ($i = 0; $i < count($photosType); $i++) { ?>
												<option value="<?php echo $photosType[$i]["param_value"]; ?>"><?php echo $photosType[$i]["param_description"]; ?></option>	
											<?php } ?>
										</select>
									</div>
									<div class="col-6 input-group input-group-sm">
										<input type="file" name="userfile" />
									</div>
									<div class="col-3">
										<button type="submit" id="btnPhoto" name="btnPhoto" class="btn btn-warning btn-sm" >
											Upload <span class="fa fa-save" aria-hidden="true" />
										</button> 
									</div>
								</div>
							</div>
						</form>
						<?php 
							if($rentPhotos)
							{
						?>
						<hr>
						<table class="table">
							<thead>
								<tr class="small">
									<th class='text-center' style="width: 20%">Photo</th>
									<th style="width: 30%">Type</th>
									<th style="width: 30%">User</th>
									<th class='text-center' style="width: 20%">Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($rentPhotos as $data):
								?>
								<tr class="small">
									<td class='text-center'>
									  <a href="<?php echo base_url($data['equipment_photo']); ?>" data-toggle="lightbox" data-title="<?php echo $data['type']; ?>" data-gallery="gallery">
									    		<img src="<?php echo base_url($data['equipment_photo']); ?>" class="img-rounded" alt="Equipment Photo" width="60" height="60"/>
									  </a>
									</td>
									<td><?php echo $data['type']; ?></td>
									<td><?php echo $data['name']; ?></td>
									<td class='text-center text-muted'><?php echo $data['date']; ?></td>
								</tr>
								<?php
									endforeach;
								?>
							</tbody>
						</table>
						<?php
							}
						?>
					</div>
				</div>
			</section>
    </div>
	</div>
</section>

<!--INICIO Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="datosCondition">

		</div>
	</div>
</div>
<!--FIN Modal -->
  
<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/ekko-lightbox/ekko-lightbox.css"); ?>">
<script src="<?php echo base_url('assets/bootstrap/plugins/ekko-lightbox/ekko-lightbox.min.js'); ?>"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>