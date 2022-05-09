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
					                <br><br>
					                <strong>Current equipment condition: </strong><?php echo $info[0]['clean']==1?"Clean":"To be clean"; ?><br>
					                <strong>Type of rent : </strong><?php echo $info[0]['name_type_contract']; ?>
					                <p class="text-<?php echo $info[0]['clase']; ?>"><strong>Actual status: </strong><?php echo $info[0]['name_status']; ?></p>
<a class="btn btn-primary" href="<?php echo base_url("external/add_client_signature/manager/" . $info[0]["id_rent"] . "/x"); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Signature </a>				                
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
					                <strong>Current Fuel: </strong><?php echo $info[0]['param_description']; ?><br><br>
					                <strong>Does the unit has any damage(s)?: </strong><?php echo $info[0]['damage']==1?"Si":"No"; ?><br>
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

				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Attachements</h3>
					</div>
					<div class="card-body">
						<div class="direct-chat-messages">
							<table class="table">
								<thead>
									<tr class="small">
										<th class='text-center' style="width: 5%">#</th>
										<th style="width: 75%">Attachement</th>
										<th class='text-center' style="width: 20%">Date</th>
									</tr>
								</thead>
								<tbody>
							<?php 
								if($rentAttachement)
								{
									$i = 0;
									foreach ($rentAttachement as $data):
										$i++;
							?>
									<tr>
										<td class="small">
											 <?php echo $i; ?>
										</td>
										<td class="small" style="width: 15%">
											<b><?php echo $data['type']; ?></b>
										</td>
										<td class="text-center small">
											<?php echo $data['date']; ?>
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
			</section>

			<section class="col-lg-6 connectedSortable">

				<div class="card card-yellow">
					<div class="card-header">
						<h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Photographic Record</h3>
					</div>
					<div class="card-body">
						<?php 
							if($rentPhotos){
						?>
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