<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
								url: base_url + 'dashboard/cargarModalRent',
                data: {'idRent': oID},
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
									<span class="fa fa-plus" aria-hidden="true"></span> Rent Equipment
							</button>
						</div>
					</div>
					<div class="card-body">

					<?php 										
						if(!$info){ 
							echo '<div class="col-lg-12">
									<p class="text-danger"><span class="fa fa-alert" aria-hidden="true"></span> No data was found.</p>
								</div>';
						}else{
					?>
						<table id="rentas" class="table table-head-fixed table-striped table-hover">
							<thead>
								<tr>
								<th class="text-center">#</th>
								<th>Client</th>
								<th>Equipment</th>
								<th>From</th>
								<th>Until</th>
								<th>Status</th>
								<th>Edit</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							$i=0;
							foreach ($info as $lista):
									$i++;
									echo "<tr>";
									echo "<td class='text-center'>" . $i . "</td>";
									echo "<td>" . $lista['param_client_name'] . "</td>";
									echo "<td>" . $lista['unit_number'] . "--->" . $lista['description'] . "</td>";
									echo "<td>" . $lista['start_date'] . "</td>";
									echo "<td>" . $lista['finish_date'] . "</td>";
									echo "<td class='text-" . $lista['clase'] . "'><strong>" . $lista['name_status'] . "</strong>";
									echo '<p class="text-info">Last message:<br>' . $lista['last_message'] . '</p>';
									echo "</td>";
									echo "</td>";									
									echo "<td class='text-center'>";
									?>
			            <div class="btn-group-horizontal">
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_rent']; ?>">
										Edit
									</button>
									<a href="<?php echo base_url("dashboard/rent_details/" . $lista['id_rent']); ?>" class="btn btn-info btn-xs">Details <span class="glyphicon glyphicon-edit" aria-hidden="true"></a>
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