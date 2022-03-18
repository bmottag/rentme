<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="MottaClick">
	<meta name="baseurl" content="<?php echo base_url()?>" />
	<title>SISTEMAScontrol.</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/fontawesome-free/css/all.min.css"); ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"); ?>">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/select2/css/select2.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"); ?>">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
	<!-- JQVMap -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/jqvmap/jqvmap.min.css"); ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/dist/css/adminlte.min.css"); ?>">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"); ?>">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/daterangepicker/daterangepicker.css"); ?>">
	<!-- summernote -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/summernote/summernote-bs4.min.css"); ?>">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"); ?>">
	<!-- Toastr -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/toastr/toastr.min.css"); ?>">
	<!-- jQuery -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/jquery/jquery.min.js"); ?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<!-- jQuery validate-->
	<script type="text/javascript" src="<?php echo base_url("assets/js/general/general.js"); ?>"></script>
    <!-- jquery-validation -->
    <script src="<?php echo base_url("assets/bootstrap/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/bootstrap/plugins/jquery-validation/additional-methods.min.js"); ?>"></script>


	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"); ?>">

</head>
<?php
$idRole = $this->session->idRole;
$darkStyle = $idRole==99?"dark-mode":"";
?>
<body class="hold-transition sidebar-mini layout-fixed <?php echo $darkStyle; ?>">
	<div class="wrapper">

		<!-- 
		<div class="preloader flex-column justify-content-center align-items-center">
			<img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
		</div>
Preloader -->
		<?php
		//consultar enlaces
		$ci = &get_instance();
		$ci->load->model("general_model");

		$leftMenu = '';
		$topMenu = '';
		$itemsLeftMenu = FALSE;
		$itemsTopMenu = FALSE;

		//Left MENU 
		$arrParam = array(
			"idRole" => $idRole,
			"menuType" => 1,
			"menuStatus" => 1
		);
		$itemsLeftMenu = $this->general_model->get_role_menu($arrParam);

		//Top MENU 
		$arrParam = array(
			"idRole" => $idRole,
			"menuType" => 2,
			"menuStatus" => 1
		);
		$itemsTopMenu = $this->general_model->get_role_menu($arrParam);		

		if($itemsLeftMenu)
		{
			foreach ($itemsLeftMenu as $item):
						
				if($item['menu_url'] && $item['menu_url'] != '')
				{
					$menuURL = base_url($item['menu_url']);
					$leftMenu .= '<li class="nav-item">';
					$leftMenu .= '<a href="' . $menuURL . '" class="nav-link"><i class=" nav-icon fa ' . $item['menu_icon'] . ' fa-fw"></i><p> ' . $item['menu_name'] . '</p></a>';
					$leftMenu .= '</li>';					
				}else{
					//enlaces del menu
					$arrParam = array(
						"idRole" => $idRole,
						"idMenu" => $item['fk_id_menu'],
						"linkStatus" => 1,
						"menuType" => 1
					);
					$links = $this->general_model->get_role_access($arrParam);		

					if($links){
						$leftMenu .= '<li class="nav-item">';
						$leftMenu .= '<a href="#" class="nav-link">';
						$leftMenu .= '<i class="nav-icon fas fa ' . $item['menu_icon'] . '"></i><p>' . $item['menu_name'] . ' <i class="right fas fa-angle-left"></i>';
						$leftMenu .= '</p></a>';
						
						$leftMenu .= '<ul class="nav nav-treeview"">';
						
						foreach ($links as $list):
							//System URL
							if($list['link_type'] == 1){
								$linkURL = base_url($list['link_url']);
								
								$leftMenu .= '<li class="nav-item">';
								$leftMenu .= '<a href="' . $linkURL . '" class="nav-link"><p>' . $list['link_name'] . '</p></a>';
								$leftMenu .= '</li>';
							//Complete URL
							}elseif($list['link_type'] == 2){
								$linkURL = $list['link_url'];
								
								$leftMenu .= '<li class="nav-item">';
								$leftMenu .= '<a href="' . $linkURL . '" target="_blank" class="nav-link"><p>' . $list['link_name'] . '</p></a>';
								$leftMenu .= '</li>';
							//Complete DIVIDER
							}else{
								$linkURL = base_url($list['link_url']);
								$leftMenu .= '<li class="divider"></li>';
							}
						endforeach;
						
						$leftMenu .= '</ul>';
						$leftMenu .= '</li>';						
					}
				}
			endforeach;
		}

		if($itemsTopMenu)
		{
			foreach ($itemsTopMenu as $item):
							
				if($item['menu_url'] && $item['menu_url'] != '')
				{
					$menuURL = base_url($item['menu_url']);
					$topMenu .= '<li class="nav-item d-none d-sm-inline-block">';
					$topMenu .= '<a href="' . $menuURL . '" class="nav-link">';
					$topMenu .= '<i class="fa ' . $item['menu_icon'] . '"></i> ' . $item['menu_name'];
					$topMenu .= '</a>';
					$topMenu .= '</li>';
					
				}else{
					//enlaces del menu
					$arrParam = array(
						"idRole" => $idRole,
						"idMenu" => $item['fk_id_menu'],
						"linkStatus" => 1,
						"menuType" => 2
					);
					$links = $this->general_model->get_role_access($arrParam);		

					if($links){
						$topMenu .= '<li class="nav-item dropdown">';
						$topMenu .= '<a class="nav-link" data-toggle="dropdown" href="#">';
						$topMenu .= '<i class="fa ' . $item['menu_icon'] . '"></i> ' . $item['menu_name'] . ' <i class="fa fa-caret-down"></i>';
						$topMenu .= '</a>';
						
						$topMenu .= '<div class="dropdown-menu dropdown-menu-right">';
						
						foreach ($links as $list):
							//System URL
							if($list['link_type'] == 1){
								$linkURL = base_url($list['link_url']);
								$topMenu .= '<a href="' . $linkURL . '" class="dropdown-item"><i class="fa ' . $list['link_icon'] . ' fa-fw"></i> ' . $list['link_name'] . '</a>';

							//Complete URL
							}elseif($list['link_type'] == 2 || $list['link_type'] == 4 || $list['link_type'] == 5){
								$linkURL = $list['link_url'];
								$topMenu .= '<a href="' . $linkURL . '" target="_blank" class="dropdown-item"><i class="fa ' . $list['link_icon'] . ' fa-fw"></i> ' . $list['link_name'] . '</a>';
							//DIVIDER
							}else{
								$linkURL = base_url($list['link_url']);
								$topMenu .= '<div class="dropdown-divider"></div>';
							}
						

						endforeach;
						
						$topMenu .= '</div>';
						$topMenu .= '</li>';						
					}
				}
			endforeach;
		}

		$data["leftMenu"] = $leftMenu;
		$data["topMenu"] = $topMenu;
		?>

		<?php 
		$this->load->view("template/menu", $data); 
		?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<?php if (isset($pageHeaderTitle) && ($pageHeaderTitle != '')) { ?>
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0"><?php echo $pageHeaderTitle; ?></h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active">Dashboard</li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->
			<?php } ?>
			<!-- Start of content -->
			<?php
				if (isset($view) && ($view != '')) {
					$this->load->view($view);
				}
			?>
			<!-- End of content -->

		<!-- /.content -->
		</div>

		<!-- Start of footer -->
		<?php
			if (isset($footer) && ($footer != '')) {
				$this->load->view("template/footer", $data);
			}
		?>
		<!-- End of footer -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<script>
	  $.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/select2/js/select2.full.min.js"); ?>"></script>
	<!-- ChartJS -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/chart.js/Chart.min.js"); ?>"></script>
	<!-- JQVMap -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/jqvmap/jquery.vmap.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/plugins/jqvmap/maps/jquery.vmap.usa.js"); ?>"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/jquery-knob/jquery.knob.min.js"); ?>"></script>
	<!-- daterangepicker -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/moment/moment.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/summernote/summernote-bs4.min.js"); ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url("assets/bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url("assets/bootstrap/dist/js/adminlte.js"); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url("assets/bootstrap/dist/js/demo.js"); ?>"></script>
	<!-- SweetAlert2 -->
	<script src="<?php echo base_url('assets/bootstrap/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url('assets/bootstrap/plugins/toastr/toastr.min.js'); ?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
</body>
</html>