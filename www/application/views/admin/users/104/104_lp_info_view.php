
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<?php require_once '104_lp_info_update.php';?>
<?php require_once '104_lp_info_create.php';?>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["lp_info_title"]?></h2>
				<h5><?php echo $arr_ui_string["lp_info_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["lp_info_title"]?></h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">

								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
											foreach ( $arr_ui_string ["lp_info_fields"] as $row ) {
												echo "<th>$row</th>";
											}
										 ?>
									</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--End Advanced Tables -->
		
		<div class="row" style="text-align: right;padding-right: 10px;">
			<button class="btn btn-primary" onclick="onClickRegister()"><?php echo $arr_ui_string['btn_title_register'];?></button> 
		</div>
		
	</div>
</div>
</div>

</div>
<!-- /. PAGE INNER  -->

<!-- DATA TABLE SCRIPTS -->
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.js"></script>

<script>

var modifyLpID="";

function loadTable() {

	var baseURL = "<?php echo base_url(); ?>";
	var urlData = baseURL+"users/POST_LP_INFO_VIEW";
	
	dataTable = $('#dataTables-example').dataTable({
		"processing": true,
		"lengthChange": false,
		"searching": false,
		"paging": false,
		"scrollY":  400,
        "scrollX": true,
		"pageLength":<?php echo $page_length;?>,
		"info": true,
		"language": {
			  "info": "_START_- _END_(_TOTAL_)",
			  "paginate": {
				  "previous": "<?php echo $arr_ui_string['btn_title_prev'];?>",
				  "next": "<?php echo $arr_ui_string['btn_title_next'];?>"
		      }
		 },
		"serverSide": true,
	    "ajax": {
	        "url": urlData,
	        "type":"POST"
	     },
	     "autoWidth": false,
		 "columns": [
		             { "data": "LP_ID" , "class": "alignCenter"},
		             { "data": "LP_NAME", "class": "alignCenter" },
		             { "data": "ENABLED", "class": "alignCenter" },
		             { "data": "PHONE","class": "alignCenter"  },
		             { "data": "EMAIL","class": "alignCenter"  },
		             { "data": "ADDR","class": "alignCenter"  },
		             { "data": "COMMENT","class": "alignCenter"  },
		             { "data": "LAST_UPDATE","class": "alignCenter"  },
		             { "data": "LAST_UPDATER","class": "alignCenter"  }
		         ]
	});
}

function onLoad() {
	loadTable();
	var table = $('#dataTables-example').DataTable();
	$('#dataTables-example tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        window.showUpdateDialog(data);
    } );	

	 var baseURL = "<?php echo base_url(); ?>";
		requestURL = baseURL + 'users/POST_CREATE_LP_INFO_VIEW';
		 $("#btn_create").click(function(){
			 $.ajax({
	                url: requestURL,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_lp_name:$('#tv_create_lp_name').val(),
	                    i_address:$('#tv_create_address').val(),
	                    i_phone1:$('#tv_create_phone_1').val(),
	                    i_phone2:$('#tv_create_phone_2').val(),
	                    i_email:$('#tv_create_email').val(),
	                    i_comment:$('#tv_create_comment').val(),
	                    i_addr:$('#tv_create_address').val(),
	                    i_enabled:$('#cb_create_enable').val()
	                },
	                success: function (response) {
	                	if(response.result_code == <?php echo VALUE_OK;?>) {
	                		$('#dataTables-example').DataTable().ajax.reload();
	                	}
	                	else {
	                		showAlert(msgErrArray[response.result_code]);
	                	}	
	                	 $('#myCreateModalHorizontal').modal('toggle');
	                },
	                error: function (jqXHR, msg, erro) {
	                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
	                	$('#dataTables-example').DataTable().ajax.reload();
	                	$('#myCreateModalHorizontal').modal('toggle');
	                }
	            });
		 }); 

		requestURL1 = baseURL + 'users/POST_UPDATE_LP_INFO_VIEW';
		 $("#btn_modify").click(function(){
			 $.ajax({
	                url: requestURL1,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_lp_id:modifyLpID,
	                    i_lp_name:$('#tv_change_lp_name').val(),
	                    i_address:$('#tv_change_address').val(),
	                    i_phone1:$('#tv_change_phone_1').val(),
	                    i_phone2:$('#tv_change_phone_2').val(),
	                    i_email:$('#tv_change_email').val(),
	                    i_comment:$('#tv_change_comments').val(),
	                    i_addr:$('#tv_change_address').val(),
	                    i_enabled:$('#cb_change_enable').val()
	                },
	                success: function (response) {
	                	if(response.result_code == <?php echo VALUE_OK;?>) {
	                		$('#dataTables-example').DataTable().ajax.reload();
	                	}
	                	else {
	                		showAlert(msgErrArray[response.result_code]);
	                	}	
	                	 $('#myUpdateModalHorizontal').modal('toggle');
	                },
	                error: function (jqXHR, msg, erro) {
	                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
	                	$('#dataTables-example').DataTable().ajax.reload();
	                	$('#myUpdateModalHorizontal').modal('toggle');
	                }
	            });
		 }); 
}

function showUpdateDialog(data) {

	modifyLpID = data['LP_ID'];
   	$('#tv_change_lp_name').val(data['LP_NAME']);
	$('#tv_change_address').val(data['ADDRESS']);
	$('#tv_change_phone_1').val(data['PHONE1']);
	$('#tv_change_phone_2').val(data['PHONE2']);
	$('#tv_change_email').val(data['EMAIL']);
    $('#tv_change_comment').val(data['COMMENT']);
    $('#tv_change_address').val(data['ADDR']);
     
	$('#cb_change_enable').val(data['ENABLED']);
	$('#cb_change_enable').selectpicker('refresh');
    		
	 $('#myUpdateModalHorizontal').modal('show');
}

function onClickRegister() {
	var baseURL = "<?php echo base_url(); ?>";

	$('#tv_create_lp_name').val("");
	$('#tv_create_address').val("");
	$('#tv_create_phone_1').val("");
	$('#tv_create_phone_2').val("");
	$('#tv_create_email').val("");
	$('#tv_create_comment').val("");
	$('#tv_create_address').val("");
	
	$('#cb_create_enable').val('Y');
	$('#cb_create_enable').selectpicker('refresh');
    		
	 $('#myCreateModalHorizontal').modal('show');
}
</script>

