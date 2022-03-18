<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'settings/cargarModalJob',
                data: {'idJob': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});

function seleccionar_todo(){
   for (i=0;i<document.jobs_status.elements.length;i++)
      if(document.jobs_status.elements[i].type == "checkbox")
         document.jobs_status.elements[i].checked=1
} 


function deseleccionar_todo(){
   for (i=0;i<document.jobs_status.elements.length;i++)
      if(document.jobs_status.elements[i].type == "checkbox")
         document.jobs_status.elements[i].checked=0
} 
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
									<span class="fa fa-plus" aria-hidden="true"></span> Add Job Code/Name
							</button>
							<a type="button" class="btn btn-info swalDefaultInfo <?php if($jobStatus == 1){ echo 'active';} ?>" href="<?php echo base_url("settings/job/1"); ?>">
								Active Job Code/Name
							</a>
							<a type="button" class="btn btn-info swalDefaultInfo <?php if($jobStatus == 2){ echo 'active';} ?>" href="<?php echo base_url("settings/job/2"); ?>">
								Inactive Job Code/Name
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
<form  name="jobs_status" id="jobs_status" method="post" action="<?php echo base_url("settings/jobs_status/$jobStatus"); ?>">

						<div class="btn-group">
							<a class="btn btn-default" href="javascript:seleccionar_todo()">Check all</a>
							<a class="btn btn-default" href="javascript:deseleccionar_todo()">Uncheck all</a> 
						</div>	
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
								<th>Client</th>
								<th>Job Code/Name</th>
								<th class="text-center">Status 

<button type="submit" class="btn btn-primary btn-xs" id="btnSubmit2" name="btnSubmit2" >
	Update <span class="fa fa-edit" aria-hidden="true">
</button>

								</th>
								<th class="text-center">Edit</th>
								</tr>
							</thead>
							<tbody>							
							<?php
								foreach ($info as $lista):
										echo "<tr>";
										echo "<td>" . $lista['param_client_name'] . "</td>";
										echo "<td>" . $lista['job_description'] . "</td>";
										echo "<td class='text-center'>";
										switch ($lista['status']) {
											case 1:
												$valor = 'Active';
												$clase = "text-success";
												$estado = TRUE;
												break;
											case 2:
												$valor = 'Inactive';
												$clase = "text-danger";
												$estado = FALSE;
												break;
										}
										echo '<p class="' . $clase . '"><strong>' . $valor . '</strong>';
										$data = array(
											'name' => 'job[]',
											'id' => 'job',
											'value' => $lista['id_job'],
											'checked' => $estado,
											'style' => 'margin:10px'
										);
										echo form_checkbox($data);
										echo '</p>';
										echo "</td>";
										echo "<td class='text-center'>";
							?>
										<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_job']; ?>" >
											Edit <span class="fa fa-edit" aria-hidden="true">
										</button>										
							<?php
										echo "</td>";
										echo "</tr>";
								endforeach;
							?>
							</tbody>
						</table>
</form>
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