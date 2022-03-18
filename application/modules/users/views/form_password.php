<script type="text/javascript" src="<?php echo base_url("assets/js/validate/password.js"); ?>"></script>

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
							<?php if($information[0]['photo']){ ?>
								<img class="profile-user-img img-fluid img-circle" src="<?php echo base_url($information[0]['photo']); ?>" alt="User profile picture">
							<?php } ?>
						</div>
						<h3 class="profile-username text-center"><?php echo $information[0]['first_name'] . ' ' . $information[0]['last_name']; ?></h3>

						<p class="text-muted text-center"><?php echo $information[0]['role_name']; ?></p>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
							<b>Email:</b> <a class="float-right"><?php echo $information[0]['email']; ?></a>
							</li>
							<li class="list-group-item">
							<b>Movil Number:</b> <a class="float-right"><?php echo $information[0]['movil']; ?></a>
							</li>
							<li class="list-group-item">
							<b>User Name:</b> <a class="float-right"><?php echo $information[0]['log_user']; ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">New Password Form</h3>
					</div>

					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("users/update_password"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information[0]["id_user"]; ?>"/>
						<input type="hidden" id="hddUser" name="hddUser" value="<?php echo $information[0]["log_user"]; ?>"/>
						<input type="hidden" id="hddStatus" name="hddStatus" value="<?php echo $information[0]["status"]; ?>"/>
						<div class="card-body">
							<p class="text-primary"><i class="icon fa fa-exclamation-triangle"></i> Enter your new password and confirm.</p>
							<div class="form-group">
								<label for="exampleInputEmail1">Password: *</label>
								<input type="text" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" >
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Confirm Password: *</label>
								<input type="text" id="inputConfirm" name="inputConfirm" class="form-control" placeholder="Confirm Password" >
							</div>
						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

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