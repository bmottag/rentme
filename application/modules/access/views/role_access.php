<script type="text/javascript" src="<?php echo base_url("assets/js/validate/access/role_access.js"); ?>"></script>
<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'access/cargarModalRoleAccess',
                data: {'idPermiso': oID},
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
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="x">
								<span class="fa fa-plus" aria-hidden="true"></span> Add Role Access
						</button>

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
						if($info){
					?>				
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
									<th>Menu name</th>
									<th>Link name</th>
									<th class="text-center">Rol name</th>
									<th class="text-center">Order</th>
									<th class="text-center">Edit/Delete</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['menu_name'] . "</td>";
									echo "<td>" . $lista['link_name'] . "</td>";
									echo "<td class='text-center'>";
									echo '<p class="' . $lista['style'] . '"><strong>' . $lista['role_name'] . '</strong></p>';
									echo "</td>";
									echo "<td class='text-center'>" . $lista['order'] . "</td>";
									
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_access']; ?>" >
										Edit <span class="fa fa-edit" aria-hidden="true">
									</button>
									
									<button type="button" id="<?php echo $lista['id_access']; ?>" class='btn btn-danger btn-xs' title="Delete">
											<i class="fa fa-trash"></i>
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