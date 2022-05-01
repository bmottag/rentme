<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
								url: base_url + 'settings/cargarModalParamClients',
                data: {'idParamClient': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
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
				<!-- Default box -->
				<div class="card">
					<div class="card-header">
						<div class="btn-group btn-group-toggle">
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="x">
									<span class="fa fa-plus" aria-hidden="true"></span> Add Client
							</button>
						</div>
						<div class="card-tools">
							<div class="btn-group btn-group-toggle">
	                <a type="button" class="btn btn-danger swalDefaultInfo <?php if($status == 1){ echo 'active';} ?>" href="<?php echo base_url("settings/clients/1"); ?>">
	                  Active Client
	                </a>
	                <a type="button" class="btn btn-danger swalDefaultInfo <?php if($status == 2){ echo 'active';} ?>" href="<?php echo base_url("settings/clients/2"); ?>">
	                  Inactive Client
	                </a>
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0">

					<?php 										
						if(!$info){ 
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> No data was found.</p>
								</div>';
						}else{
					?>
						<table id="information" class="table table-hover text-nowrap">
							<thead>
								<tr>
								<th>Name</th>
								<th>Contact</th>
								<th class="text-center">Movil</th>
								<th>Email</th>
								<th>Address</th>
								<th class="text-center">Status</th>
								<th class="text-center">Edit</th>								
								</tr>
							</thead>
							<tbody>							
							<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['param_client_name'] . "</td>";
									echo "<td>" . $lista['param_client_contact'] . "</td>";
$movil = $lista["param_client_movil"];
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
								
									echo "<td class='text-center'>" . $resultado . "</td>";
									echo "<td>" . $lista['param_client_email'] . "</td>";
									echo "<td>" . $lista['param_client_address'] . "</td>";
									
									echo "<td class='text-center'>";
									switch ($lista['param_client_status']) {
										case 1:
											$valor = 'Active';
											$clase = "text-success";
											break;
										case 2:
											$valor = 'Inactive';
											$clase = "text-danger";
											break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_param_client']; ?>" >
										Edit <span class="fa fa-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";									
									echo "</tr>";
							endforeach;
							?>
							</tbody>
						</table>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--INICIO Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

<script>
  $(function () {
    $('#information').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>