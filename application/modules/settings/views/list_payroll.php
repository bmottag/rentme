<script>
$(function(){ 		
	$(".btn-danger").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'payroll/cargarModalHours',
                data: {'idPayroll': oID},
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

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-user-clock"></i> <?php echo $info[0]['name']; ?>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                 <b> Job</b>
                  <address>
                    <?php echo $info[0]['job_start']; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Start Address</b><br>
                  
                  	<?php echo $info[0]['address_start']; ?>
                  
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>End Address</b><br>
                  	<?php echo $info[0]['address_finish']; ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->



              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  	<strong>Task Description:</strong><br>
                  <?php echo $info[0]['task_description']; ?>
                  </p>

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  	<strong>Observation:</strong><br>
                  <?php echo $info[0]['observation']; ?>
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Date & Time</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Start Time:</th>
                        <td><?php echo $info[0]['start']; ?></td>
                      </tr>
                      <tr>
                        <th>End Time:</th>
                        <td><?php echo $info[0]['finish']; ?></td>
                      </tr>
                      <tr>
                        <th>Working Hours:</th>
                        <td><?php echo $info[0]['working_hours']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">

                  			<?php

								/**
								 * Opcion de editar horas para  SUPER ADMIN
								 */
								$userRole = $this->session->idRole;
								if($userRole==99 || $userRole==3){
							?>
									<button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#modal" id="<?php echo $info[0]['id_payroll']; ?>" >
										Edit Hours <i class="fas fa-edit"></i>
									</button>									
							<?php
								}
							?>

                </div>
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