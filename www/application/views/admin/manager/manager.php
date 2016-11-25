
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<?php require_once '902/902_manager_create.php';?>
<?php require_once '902/902_manager_update.php';?>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["manager_info_title"]?></h2>
				<h5><?php echo $arr_ui_string["manager_info_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["manager_info_title"]?></h3>
					</div>
					<div class="panel-body">

						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<form class="form-horizontal" role="form">
								<div class="col-md-6 form-group">
									<label class="col-md-3 control-label" for="textinput" style="padding-left: 0px;"> <?php echo $arr_ui_string["manager_info_companyname"]?></label>
									<div class="col-md-3">
										<select class="selectpicker" id="cb_companyname"
											data-width="auto">
		            							<?php
																$arr = $list_company;
																echo '<option value="'.VALUE_ALL.'">' . $arr_ui_string["btn_select_all"] . '</option>';
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company['IDX'].'">' . $company['COMPANY_NAME'] . '</option>';
																}
																?>
                          				</select>
									</div>
								</div>
								</form>
								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
												foreach ( $arr_ui_string ["manager_info_fields"] as $row ) {
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
		var selectedCompanyName = "";

		function loadTable() {

			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"manager/POST_MANAGER_INFO_VIEW";
			
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
			        "type":"POST",
			        "data": function(d) {
			            d.i_company_name = selectedCompanyName;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "MANAGER_ID" , "class": "alignCenter"},
				             { "data": "MANAGER_NAME", "class": "alignCenter" },
				             { "data": "COMPANY_NAME", "class": "alignCenter" },
				             { "data": "MANAGER_PWD","class": "alignRight"  },
				             { "data": "LAST_LOGON_TM","class": "alignRight"  },
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

			 $('#cb_companyname').on('change', function(){
				    var selected = $(this).find("option:selected").text();
				    selectedCompanyName = selected;
				    if( $(this).find("option:selected").val() == <?php echo VALUE_ALL?>) {
				    	selectedCompanyName = "";
				    }
				 
				    $('#dataTables-example').DataTable().ajax.reload();
				  });

			 var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_MANAGER_CREATE';
				 $("#btn_create").click(function(){
					 $.ajax({
			                url: requestURL,
			                type: "POST", // To protect sensitive data
			                data: {
			                    ajax: true,
			                    i_new_manager_id:$('#tv_create_account').val(),
			                    i_new_manager_name:$('#tv_create_name').val(),
			                    i_new_manager_pwd:$('#tv_create_passwd').val(),
			                    i_new_company_name:$('#cb_create_companyname').val(),
			                    i_new_comments:$('#tv_create_comments').val()
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

				
					requestURL1 = baseURL + 'manager/POST_MANAGER_MODIFY';
					 $("#btn_modify").click(function(){
						 $.ajax({
				                url: requestURL1,
				                type: "POST", // To protect sensitive data
				                data: {
				                    ajax: true,
				                    i_target_manager_id:$('#lb_change_account').text(),
				                    i_target_manager_name:$('#tv_change_name').val(),
				                    i_target_manager_pwd:$('#tv_change_passwd').val(),
				                    i_target_comment:$('#tv_change_comments').val(),
				                    i_target_company_name:$('#cb_change_companyname').val()
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
		
           	$('#lb_change_account').text(data['MANAGER_ID']);
           	$('#tv_change_name').val(data['MANAGER_NAME']);
			$('#tv_change_passwd').val(data['MANAGER_PWD']);
            $('#tv_change_comments').val(data['COMMENTS']);
             
			$('#cb_change_companyname').val(data['COMPANY_NAME']);
			$('#cb_change_companyname').selectpicker('refresh');
            		
			 $('#myUpdateModalHorizontal').modal('show');
			 
			
		}

		function onClickRegister() {
			var baseURL = "<?php echo base_url(); ?>";
			 $('#myCreateModalHorizontal').modal('show');
			
		}
			
</script>

