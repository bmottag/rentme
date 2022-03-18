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
						<table id="catalogo" class="table table-head-fixed table-striped table-hover">
							<thead>
								<tr>
								<th class="text-center">#</th>
								<th>Nombre</th>
								<th class="text-center">Sigla</th>
								<th>Responsable</th>
								<th>Enlace Aplicación</th>
								<th class="text-center">Enlaces</th>
								</tr>
							</thead>
							<tbody>							
							<?php
							$i=0;
							foreach ($infoCatalogo as $lista):
									$i++;
									echo "<tr>";
									echo "<td class='text-center'>" . $i . "</td>";
									echo "<td>" . $lista['nombre_sistema'] . "</td>";
									echo "<td class='text-center'>" . $lista['sigla_sistema'] . "</td>";
									echo "<td>";
									echo "<b>Responsable técnico:</b><br>" . $lista['tecnico'];
									echo "<br><b>Responsable funcional:</b><br>" . $lista['funcional'];
									echo "</td>";
									echo "<td>";
									echo $lista['url_aplicacion'];
									echo "<br><b>IP aplicación:</b> " . $lista['servidor_aplicacion'];
									echo "<br><b>IP BD:</b> " . $lista['servidor_base_datos'];
									if($lista['observaciones']){
										echo "<p class='text-danger'><b> " . $lista['observaciones'] . '</b></p>';
									}
									echo "</td>";									
									echo "<td class='text-center'>";
						?>
			                      <div class="btn-group-vertical">
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_catalogo_sistema']; ?>" >
										Editar
									</button>

									<a href="<?php echo base_url('/control/detalles/' . $lista['id_catalogo_sistema']); ?>" class="btn btn-danger btn-xs"> Detalles </a>
			                      </div>
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