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
					                <strong>Observations: </strong><?php echo $info[0]['observations']; ?>
					                <p class="text-<?php echo $info[0]['clase']; ?>"><strong>Actual status: </strong><?php echo $info[0]['name_status']; ?></p>
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

						<table class="table">
							<tbody>
						<?php 
							if($rentStatus)
							{
								foreach ($rentStatus as $data):
						?>
								<tr>
									<td class="text-muted small" style="width: 20%">
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
			</section>

			<section class="col-lg-6 connectedSortable">

				<div class="card card-yellow">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Photographic Record</h3>
					</div>
					<div class="card-body">
						<form  name="formPhotos" id="formPhotos" method="post" enctype="multipart/form-data" action="<?php echo base_url("dashboard/do_upload_photos"); ?>">
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $info[0]["id_rent"]; ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-3 input-group input-group-sm">
										<select name="type" id="type" class="form-control">
											<option value="">Select Status...</option>
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
							if($rentPhotos)
							{
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
							}
						?>
							</tbody>
						</table>
					</div>
				</div>

			</section>

        </div>
	</div>
</section>
  
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