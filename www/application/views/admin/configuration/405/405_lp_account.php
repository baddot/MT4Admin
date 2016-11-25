<?php require_once '405_lp_account_create.php';?>
<?php require_once '405_lp_account_modify.php';?>

<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["configuration_lp_account_title"]?></h2>
				<h5><?php echo $arr_ui_string["configuration_lp_account_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["configuration_lp_account_title"]?></h3>
					</div>
					<div class="panel-body">

						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
												foreach ( $arr_ui_string ["configuration_lp_account_fields"] as $row ) {
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
			var urlData = baseURL+"configuration/POST_LP_ACCOUNT_VIEW";
			
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
				 "ajax": {
				        "url": urlData,
				        "type":"POST",
				        "data": function(d) {
				          
				        }
				     },
				"serverSide": true,
			     "autoWidth": false,
				 "columns": [
				             { "data": "LP_ID", "class": "alignCenter" },
				             { "data": "LP_NAME", "class": "alignCenter" },
				             { "data": "LP_ACCOUNT","class": "alignRight"  },
				             { "data": "COMMENTS","class": "alignRight" }
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
				requestURL = baseURL + 'configuration/POST_LP_ACCOUNT_CREATE';
				 $("#btn_create").click(function(){
					 $.ajax({
			                url: requestURL,
			                type: "POST", // To protect sensitive data
			                data: {
			                    ajax: true,
			                    i_lp_id:$('#cb_create_lp_id').val(),
			                    i_lp_account:$('#tv_create_lp_name').val(),
			                    i_lp_comments:$('#tv_create_comments').val()
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

				
					requestURL1 = baseURL + 'configuration/POST_LP_ACCOUNT_MODIFY';
					 $("#btn_modify").click(function(){
						 $.ajax({
				                url: requestURL1,
				                type: "POST", // To protect sensitive data
				                data: {
				                    ajax: true,
				                    i_lp_id:$('#cb_update_lp_id').val(),
				                    i_lp_account:$('#tv_update_lp_name').val(),
				                    i_lp_comments:$('#tv_update_comments').val()
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
		 	$('#cb_update_lp_id').val(data['LP_ID']);
			$('#cb_update_lp_id').selectpicker('refresh');
           	$('#tv_update_lp_name').val(data['LP_ACCOUNT']);
			$('#tv_update_comments').val(data['COMMENTS']);
            		
			 $('#myUpdateModalHorizontal').modal('show');
		}
		
		function onClickRegister() {
			var baseURL = "<?php echo base_url(); ?>";
			 $('#myCreateModalHorizontal').modal('show');
		}
			
</script>

