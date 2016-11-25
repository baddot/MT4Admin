
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<?php require_once '102_agent_info_modify.php';?>
<?php require_once '102_agent_info_create.php';?>
<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["ib_info_title"]?></h2>
				<h5><?php echo $arr_ui_string["ib_info_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["ib_info_title"]?></h3>
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
											foreach ( $arr_ui_string ["ib_info_fields"] as $row ) {
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

function loadTable() {

	var baseURL = "<?php echo base_url(); ?>";
	var urlData = baseURL+"users/POST_AGENT_INFO_VIEW";
	
	dataTable = $('#dataTables-example').dataTable({
		"processing": true,
		"lengthChange": false,
		"searching": true,
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
		             { "data": "AGENT_ACCOUNT" , "class": "alignCenter"},
		             { "data": "AGENT_NAME", "class": "alignCenter" },
		             { "data": "AGENT_COMPANY", "class": "alignCenter" },
		             { "data": "AGENT_GROUP","class": "alignCenter"  },
		             { "data": "COMM_POINT","class": "alignCenter"  },
		             { "data": "UPPER_AGENT_ACCOUNT","class": "alignCenter"  },
		             { "data": "ENABLED","class": "alignCenter"  },
		             { "data": "HIERARCHY","class": "alignCenter"  },
		             { "data": "CREATE_DATE","class": "alignCenter"  },
		             { "data": "LAST_UPDATE","class": "alignCenter"  }
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
}

function showUpdateDialog(data) {

	var modifyAgentID = data['AGENT_ACCOUNT'];
   	$('#lb_agent_name').text(data['AGENT_NAME']);
	$('#lb_wl_name').text(data['AGENT_COMPANY']);
	$('#tv_comment_pt').val(data['COMM_POINT']);
    $('#tv_dlg_hierarchy').val(data['HIERARCHY']);
     
	$('#cb_dlg_enabled').val(data['ENABLED']);
	$('#cb_dlg_enabled').selectpicker('refresh');

	$('#cb_dlg_group').val(data['AGENT_GROUP']);
	$('#cb_dlg_group').selectpicker('refresh');
	
	$('#cb_dlg_agent').val(data['UPPER_AGENT_ACCOUNT']);
	$('#cb_dlg_agent').selectpicker('refresh');
			
	 $('#myUpdateModalHorizontal').modal('show');
	 
	var baseURL = "<?php echo base_url(); ?>";
	requestURL = baseURL + 'users/POST_UPDATE_AGENT_INFO_VIEW';
	 $("#btn_modify").click(function(){
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    i_agent_account:modifyAgentID,
                    i_agent_group:$('#cb_dlg_group').val(),
                    i_agent_company:$('#lb_wl_name').text(),
                    i_upper_agent:$('#cb_dlg_agent').val(),
                    i_hierarchy:$('#tv_dlg_hierarchy').val(),
                    i_comment:$('#tv_comment_pt').val(),
                    i_comm_tp:'P',
                    i_enable:$('#cb_dlg_enabled').val()
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

function onClickRegister() {
	var baseURL = "<?php echo base_url(); ?>";

	$('#lb_create_wl_name').text("");
	$('#tv_create_comment_pt').val("");
    $('#tv_create_hierarchy').val("");
     
	$('#cb_create_enabled').val(0);
	$('#cb_create_enabled').selectpicker('refresh');

	$('#cb_create_group').val(0);
	$('#cb_create_group').selectpicker('refresh');
	
	$('#cb_create_upper_agent').val(0);
	$('#cb_create_upper_agent').selectpicker('refresh');

	$('#cb_create_agent_name').val(0);
	$('#cb_create_agent_name').selectpicker('refresh');
	
	$('#myCreateModalHorizontal').modal('show');
	 
	 var baseURL = "<?php echo base_url(); ?>";
		requestURL = baseURL + 'users/POST_CREATE_AGENT_INFO_VIEW';
		 $("#btn_create").click(function(){
			 $.ajax({
	                url: requestURL,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_agent_account:$('#cb_create_agent_name').val(),
	                    i_agent_group:$('#cb_create_group').val(),
	                    i_agent_company:$('#lb_create_wl_name').text(),
	                    i_upper_agent:$('#cb_create_upper_agent').val(),
	                    i_hierarchy:$('#tv_create_hierarchy').val(),
	                    i_comment:$('#tv_create_comment_pt').val(),
	                    i_comm_tp:'P',
	                    i_enable:$('#cb_create_enabled').val()
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
}
</script>

