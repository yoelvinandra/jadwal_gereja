<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Jadwal Pelayanan | Selamat Datang</title>
	<!-- Tell the browser to be responsive to screen width -->
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css"> -->
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/buttons.dataTables.min.css"> -->
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.min.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

	<!-- AdminLTE Skins. Choose a skin from the css/skins
		   folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.min.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	
	<!-- jQuery 3 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<!-- button datatable -->
	<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
	<!-- Sparkline -->
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
	<!-- bootstrap datepicker -->
	<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<!-- iCheck 1.0.1 -->
	<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- Slimscroll -->
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/js/adminlte.min.js"></script>
	<!-- ChartJS -->
	<script src="<?php echo base_url(); ?>assets/bower_components/chart.js/Chart.js"></script>
	<!-- date-range-picker -->
	<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- timepicker -->
	<script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- <script src="assets/js/sweetalert.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/sweetalert2.all.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.number.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/switchery.min.js"></script>
	<!-- <script src="<?php echo base_url(); ?>assets/js/moment.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<!-- <script src="<?php echo base_url(); ?>assets/js/moment.js"></script> -->
	<style>
		tr td{
			cursor:pointer;
		}
	</style>
</head>

<div class="modal fade" id="modal-menu" >
    <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
        <div class="modal-body">
		<div class="row">
			<div class="col-md-12" style="text-align:center;">
				<label style="font-size:20pt;">Menu</label>
			</div>
			<br>
			<br>
			<br>
			<!--TRANSAKSI-->
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>Home/page/pelayan">
					<div class="small-box bg-green" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Pelayan Tuhan
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>Home/page/jenispelayanan">
					<div class="small-box bg-yellow" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Jenis Pelayanan
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>Home/page/jadwal">
					<div class="small-box bg-blue" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Jadwal Pelayanan
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?php echo base_url(); ?>Home/page/laporan">
					<div class="small-box bg-purple" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Cetak Laporan
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<br>
				<a href="<?php echo base_url(); ?>Wordandworship?menu=1">
					<div class="small-box bg-black" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Word & Worship
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<br>
				<a href="<?php echo base_url(); ?>Home/page/keluar">
					<div class="small-box bg-red" style="cursor:pointer;">
						<div class="inner" style="text-align:center;">
							Keluar dari Program
						</div>
					</div>
				</a>
			</div>
        </div>
    </div>
    </div>

    </div>
</div>