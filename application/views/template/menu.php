<nav class="main-header navbar navbar-expand navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo base_url('users/profile'); ?>" class="d-block">User: <?php echo $this->session->name; ?></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<?php
		if($topMenu){
			echo $topMenu;
		}
		?>
	</ul>
</nav>