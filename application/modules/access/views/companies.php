<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
								url: base_url + 'access/cargarModalCompanies',
                data: {'idCompany': oID},
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
									<span class="fa fa-plus" aria-hidden="true"></span> Add APP Company
							</button>
			                <a type="button" class="btn btn-danger swalDefaultInfo <?php if($status == 1){ echo 'active';} ?>" href="<?php echo base_url("access/companies/1"); ?>">
			                  Active Company
			                </a>
			                <a type="button" class="btn btn-danger swalDefaultInfo <?php if($status == 2){ echo 'active';} ?>" href="<?php echo base_url("access/companies/2"); ?>">
			                  Inactive Company
			                </a>
						</div>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
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
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
								<th class="text-center">ID</th>
								<th>Name</th>
								<th>Contact</th>
								<th class="text-center">Movil</th>
								<th>Email</th>
								<th>City</th>
								<th class="text-center">Status</th>
								<th class="text-center">Edit</th>								
								</tr>
							</thead>
							<tbody>							
							<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_company'] . "</td>";
									echo "<td>" . $lista['company_name'] . "</td>";
									echo "<td>" . $lista['company_contact'] . "</td>";
$movil = $lista["company_movil"];
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
									echo "<td>" . $lista['company_email'] . "</td>";
									echo "<td>" . $lista['city'] . "</td>";
									
									echo "<td class='text-center'>";
									switch ($lista['company_status']) {
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
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_company']; ?>" >
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
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 7000
    });
  });
</script>