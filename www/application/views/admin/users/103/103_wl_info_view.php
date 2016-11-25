<?php require_once '103_wl_info_update.php';?>
<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["wl_info_title"]?></h2>
				<h5><?php echo $arr_ui_string["wl_info_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["wl_info_title"]?></h3>
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
											foreach ( $arr_ui_string ["wl_info_fields"] as $row ) {
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
	var urlData = baseURL+"users/POST_WL_INFO_VIEW";
	
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
		             { "data": "COMPANY_NAME" , "class": "alignCenter"},
		             { "data": "STATUS", "class": "alignCenter" },
		             { "data": "ENABLED", "class": "alignCenter" },
		             { "data": "OMNIBUS_ID","class": "alignCenter"  },
		             { "data": "ADDRESS","class": "alignCenter"  },
		             { "data": "PHONE","class": "alignCenter"  },
		             { "data": "EMAIL","class": "alignCenter"  },
		             { "data": "LAST_UPDATE","class": "alignCenter"  },
		             { "data": "LAST_UPDATER","class": "alignCenter"  },
		             { "data": "COMMENT","class": "alignCenter" }
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

   	$('#lb_company_name').text(data['COMPANY_NAME']);
   	$('#tv_omnibus_id').val(data['OMNIBUS_ID']);
	$('#tv_change_address').val(data['ADDRESS']);
	$('#tv_change_phone').val(data['PHONE']);
	$('#tv_change_email').val(data['EMAIL']);
    $('#tv_change_comments').val(data['COMMENT']);
     
	$('#cb_status').val(data['STATUS']);
	$('#cb_status').selectpicker('refresh');
	$('#cb_enable').val(data['STATUS']);
	$('#cb_enable').selectpicker('refresh');
    		
	 $('#myUpdateModalHorizontal').modal('show');
	 
	var baseURL = "<?php echo base_url(); ?>";
	requestURL = baseURL + 'users/POST_UPDATE_WL_INFO_VIEW';
	 $("#btn_modify").click(function(){
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    i_company_name:$('#lb_company_name').text(),
                    i_address:$('#tv_change_address').val(),
                    i_phone:$('#tv_change_phone').val(),
                    i_email:$('#tv_change_email').val(),
                    i_comment:$('#tv_change_comments').val(),
                    i_omnibus_id:$('#tv_omnibus_id').val(),
                    i_enabled:$('#cb_enable').val(),
                    i_status:$('#cb_status').val()
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
</script>

