<script type="text/javascript" src="<?php echo base_url("assets/js/validate/settings/tax.js"); ?>"></script>

<script>
$(function(){     
  $(".btn-success").click(function () { 
      var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'settings/cargarModalUpdateAPPCompany',
                data: {'idCompany': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
  });

  $(".btn-primary").click(function () { 
      var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
                url: base_url + 'settings/cargarModalAddTax',
                data: {'idTax': oID},
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
			<div class="col-md-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<?php if($appCompany[0]['company_logo']){ ?>
								<img class="profile-user-img img-fluid img-circle" src="<?php echo base_url($appCompany[0]['company_logo']); ?>" alt="User profile picture">
							<?php } ?>
						</div>
						<h3 class="profile-username text-center"><?php echo $appCompany[0]['company_name']; ?></h3>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
							<b>Contact:</b> <a class="float-right"><?php echo $appCompany[0]['company_contact']; ?></a>
							</li>
							<li class="list-group-item">
							<b>Movil Number:</b> <a class="float-right"><?php echo $appCompany[0]['company_movil']; ?></a>
							</li>
							<li class="list-group-item">
							<b>Email:</b> <a class="float-right"><?php echo $appCompany[0]['company_email']; ?></a>
							</li>
              <li class="list-group-item">
              <b>Address:</b> <a class="float-right"><?php echo $appCompany[0]['company_address']; ?></a>
              </li>
						</ul>
            <p class="text-center">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $appCompany[0]['id_company']; ?>" >
              Edit Info <i class="fas fa-edit"></i>
            </button>
            </p>
					</div>
				</div>
			</div>

      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <?php if($appCompany[0]['company_logo']){ ?>
                <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url($appCompany[0]['company_logo']); ?>" alt="User profile picture">
              <?php } ?>
            </div>
            <h3 class="profile-username text-center">Taxes to use on invoices</h3>

            <?php 
            if($taxInfo){
              echo '<table class="table text-nowrap">';
              echo '<tbody>';
                foreach ($taxInfo as $lista): 
                  echo "<tr>";
                    echo "<td>" . $lista['taxes_description'] . "</td>";
                    echo "<td class='text-center'>" . $lista['taxes_value'] . " %</td>";
                    echo "<td class='text-center'>";
                  ?>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_param_company_taxes']; ?>" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button> 
                    <button type="button" class='btn btn-danger btn-xs' id="<?php echo $lista['id_param_company_taxes']; ?>" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                  <?php
                    echo "</td>";
                    echo "</tr>";
                endforeach;
              echo '</tbody>';
            echo '</table>';
            } ?>
            <br>
            <p class="text-center">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal" id="x" >
              Add tax <i class="fas fa-plus"></i>
            </button>
            </p>
          </div>
        </div>
      </div>

			<div class="col-md-9">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Upload your photo</h3>
					</div>
					<div class="card-body">


<!-- Botones archivo  -->
               <div id="actions" class="row">
                  <div class="col-lg-6">
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add file</span>
                      </span>
                      <button type="submit" class="btn btn-primary col start">
                        <i class="fas fa-upload"></i>
                        <span>Start upload</span>
                      </button>
                      <button type="reset" class="btn btn-warning col cancel">
                        <i class="fas fa-times-circle"></i>
                        <span>Cancel upload</span>
                      </button>
                    </div>
                  </div>
                  <div class="col-lg-6 d-flex align-items-center">
                    <div class="fileupload-process w-100">
                      <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table table-striped files" id="previews">
                  <div id="template" class="row mt-2">
                    <div class="col-auto">
                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <p class="mb-0">
                          <span class="lead" data-dz-name></span>
                          (<span data-dz-size></span>)
                        </p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                      <div class="btn-group">
                        <button class="btn btn-primary start">
                          <i class="fas fa-upload"></i>
                          <span>Start</span>
                        </button>
                        <button data-dz-remove class="btn btn-warning cancel">
                          <i class="fas fa-times-circle"></i>
                          <span>Cancel</span>
                        </button>
                        <button data-dz-remove class="btn btn-danger delete">
                          <i class="fas fa-trash"></i>
                          <span>Delete</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
<!-- Botones archivo  -->													
						<?php if($error){ ?>
						<div class="alert alert-danger">
							<?php 
								echo "<strong>Error :</strong>";
								pr($error); 
							?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
						</div>
						<?php } ?>
						<br>
						<p class="text-primary">
							<i class="icon fa fa-exclamation-triangle"></i> <strong>Note: </strong><br>
							Allowed format: gif - jpg - png<br>
							Maximum size: 3000 KB<br>
							Maximum width: 2024 pixels<br>
							Maximum height: 2008 pixels<br>
						</p>
						
	
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

<script src="<?php echo base_url('assets/bootstrap/plugins/dropzone/min/dropzone.min.js'); ?>"></script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 7000
    });
  });

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "do_upload", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>


