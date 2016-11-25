<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>MT4 admin</title>
<!-- BOOTSTRAP STYLES-->
<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
<!-- MORRIS CHART STYLES-->
<link href="<?php echo base_url(); ?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" />
<!-- ADMIN STYLES-->
<link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-dialog.min.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans'
	rel='stylesheet' type='text/css' />
	<!-- TABLE STYLES-->

</head>

<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/jquery.metisMenu.js"></script>
<!-- MORRIS CHART SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris/morris.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.fileDownload.js"></script>

<script type="text/javascript">
	var msgErrArray = <?php echo json_encode($arr_ui_string['msg_err_array']);?>;
	
	function onClickLogout() {
		location.href = '<?php echo base_url(); ?>'+'admin';
	}
</script>

<body onload="onLoad()">
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation"
			style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url(); ?>admin"><h4><?php echo $arr_ui_string["admin_title"]?></h4></a>
			</div>
			<div
				style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
				Last access : 30 May 2014 &nbsp; <button type="button" href="<?php echo base_url(); ?>admin"
					class="btn btn-danger square-btn-adjust" onclick="onClickLogout()">Logout</button>
			</div>
		</nav>