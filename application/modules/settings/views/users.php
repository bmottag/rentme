<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'settings/cargarModalUsers',
                data: {'idUser': oID},
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
									<span class="fa fa-plus" aria-hidden="true"></span> Add User
							</button>
			                <a type="button" class="btn btn-info swalDefaultInfo <?php if($status == 1){ echo 'active';} ?>" href="<?php echo base_url("settings/users/1"); ?>">
			                  Active Users
			                </a>
			                <a type="button" class="btn btn-info swalDefaultInfo <?php if($status == 2){ echo 'active';} ?>" href="<?php echo base_url("settings/users/2"); ?>">
			                  Inactive Users
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
								<th class="text-center">Name</th>
								<th class="text-center">Lastname</th>
								<th class="text-center">User</th>
								<th class="text-center">Movil</th>
								<th class="text-center">Role</th>
								<th class="text-center">Status</th>
								<th class="text-center">Edit</th>
								<th class="text-center">Password</th>
								<th class="text-center">Email</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_user'] . "</td>";
									echo "<td>" . $lista['first_name'] . "</td>";
									echo "<td>" . $lista['last_name'] . "</td>";
									echo "<td class='text-center'>" . $lista['log_user'] . "</td>";
$movil = $lista["movil"];
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
									echo "<td class='text-center'>";
									echo '<p class="' . $lista['style'] . '"><strong>' . $lista['role_name'] . '</strong></p>';
									echo "</td>";
									
									echo "<td class='text-center'>";
									switch ($lista['status']) {
										case 0:
											$valor = 'New User';
											$clase = "text-primary";
											break;
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
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_user']; ?>" >
										Edit <span class="fa fa-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";
									echo "<td class='text-center'>";
							?>
									<!-- 
										Se quita la opcion de resetear la contraseña a 123456
									<a href="<?php echo base_url("admin/resetPassword/" . $lista['id_user']); ?>" class="btn btn-default btn-xs">Reset <span class="glyphicon glyphicon-lock" aria-hidden="true"></a> 
									-->
									<a href="<?php echo base_url("settings/change_password/" . $lista['id_user']); ?>" class="btn btn-default btn-xs">Change Password <span class="glyphicon glyphicon-lock" aria-hidden="true"></a>
									
							<?php
									echo "</td>";									
									echo "<td>" . $lista['email'] . "</td>";
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