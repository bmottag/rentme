<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'control/cargarModalCatalogo',
                data: {'idCatalogo': oID},
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
					<div class="card-body">

					<?php 		
						if(!$workOrderInfo){ 
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> No se encontraron registros.</p>
								</div>';
						}else{
					?>
						<table id="catalogo" class="table table-head-fixed table-striped table-hover">
							<thead>
								<tr>
								<th class='text-center'>W.O. #</th>
								<th>Client</th>
								<th class='text-center'>Date of Issue</th>
								<th>More Information</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							$i=0;
							foreach ($workOrderInfo as $lista):
									switch ($lista['status']) {
											case 0:
													$valor = 'On field';
													$clase = "text-danger";
													$icono = "fa-thumb-tack";
													break;
											case 1:
													$valor = 'In Progress';
													$clase = "text-warning";
													$icono = "fa-refresh";
													break;
											case 2:
													$valor = 'Revised';
													$clase = "text-primary";
													$icono = "fa-check";
													break;
											case 3:
													$valor = 'Send to the client';
													$clase = "text-success";
													$icono = "fa-envelope-o";
													break;
											case 4:
													$valor = 'Closed';
													$clase = "text-danger";
													$icono = "fa-power-off";
													break;
									}
							
									echo "<tr>";
									echo "<td class='text-center'>";
									echo "<a href='" . base_url('workorders/details/' . $lista['id_workorder']) . "'>" . $lista['id_workorder'] . "</a>";
									echo '<p class="' . $clase . '"><i class="fa ' . $icono . ' fa-fw"></i>' . $valor . '</p>';
									echo "<a class='btn btn-success btn-xs' href='" . base_url('workorders/details/' . $lista['id_workorder']) . "'> Edit <span class='glyphicon glyphicon-edit' aria-hidden='true'></a>";
									echo "</td>";
									echo "<td>" . $lista['param_client_name'] . "</td>";
									echo "<td class='text-center'>" . $lista['date_issue'] . "</td>";
									echo '<td>';
									echo '<strong>Work Done:</strong><br>' . $lista['observation'];
									echo '<p class="text-info"><strong>Last message:</strong><br>' . $lista['last_message'] . '</p>';
									echo '</td>';
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
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal -->

<script>
  $(function () {
    $('#catalogo').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "responsive": true,
	  "columns": [
	  	{ "width": "5%" },
	    { "width": "15%" },
	    { "width": "15%" },
	    { "width": "25%" },
	    { "width": "30%" },
	    { "width": "10%" }
	  ]
    });
  });
</script>