<?php require_once '101/101_user_info_update.php';?>
<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["users_userinfo_title"]?></h2>
				<h5><?php echo $arr_ui_string["users_userinfo_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["users_userinfo_title"]?></h3>
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
											foreach ( $arr_ui_string ["users_userinfo_fields"] as $row ) {
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
		var dataTable;
		
		function onLoad() {
			
			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"users/POST_USER_INFO_VIEW";
			
			dataTable = $('#dataTables-example').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": true,
				"paging": false,
				"scrollY":  800,
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
				             { "data": "BASKET_NAME" , "class": "alignCenter"},
				             { "data": "LOGIN", "class": "alignCenter" },
				             { "data": "NAME", "class": "alignCenter" },
				             { "data": "BALANCE","class": "alignRight"  },
				             { "data": "PREVBALANCE","class": "alignRight"  },
				             { "data": "PREVMONTHBALANCE","class": "alignRight" },
				             { "data": "LEVERAGE", "class": "alignCenter"},
				             { "data": "INTERESTRATE", "class": "alignCenter"},
				             { "data": "PREVEQUITY", "class": "alignCenter"},
				             { "data": "PREVMONEQUITY", "class": "alignCenter"},
				             { "data": "GROUP", "class": "alignCenter"},
				             { "data": "AGENTACCNO", "class": "alignCenter"},
				             { "data": "STATUS", "class": "alignCenter"},
				             { "data": "REGDATE", "class": "alignCenter"},
				             { "data": "LASTDATE", "class": "alignCenter"},
				             { "data": "MODIFY_TIME", "class": "alignCenter"},
				             { "data": "PHONE", "class": "alignCenter"},
				             { "data": "EMAIL", "class": "alignCenter"},
				             { "data": "COUNTRY", "class": "alignCenter"},
				             { "data": "CITY", "class": "alignCenter"},
				             { "data": "STATE", "class": "alignCenter"},
				             { "data": "ZIPCODE", "class": "alignCenter"}       
				         ]
			});
			var table = $('#dataTables-example').DataTable();
			$('#dataTables-example tbody').on('click', 'tr', function () {
		        var data = table.row( this ).data();
		        window.showUpdateDialog(data);
		    } );
			
		}

		function showUpdateDialog(data) {
			var baseURL = "<?php echo base_url(); ?>";
			var requestURL = baseURL + 'users/GET_LIST_AGENT_BASKET';
			$.ajax({
                url: requestURL,
                type: "get", // To protect sensitive data
                data: {
                    ajax: true,
                    i_user_account:data['LOGIN']
                },
                success: function (response) {
                	$('#lb_account').text(data['LOGIN']);
                	$('#tv_name').val(data['NAME']);
                	$('#tv_group').val(data['GROUP']);
                	$('#tv_country').val(data['COUNTRY']);
                	$('#tv_city').val(data['CITY']);
                	$('#tv_state').val(data['STATE']);
                	$('#tv_zipcode').val(data['ZIPCODE']);
                	$('#tv_phone').val(data['PHONE']);
                	$('#tv_email').val(data['EMAIL']);
					
					// cb_status: NR, RE
					$('#cb_status').val(data['STATUS']);
					$('#cb_status').selectpicker('refresh');

					$('#cb_leverage').val(data['LEVERAGE']);
					$('#cb_leverage').selectpicker('refresh');

					// cb_agent Agent Account
					$('#cb_agentaccount').find('option').remove(); // empty
					for (i = 0; i < response.list_agent.length; i++) { 
						$('#cb_agentaccount').append($("<option></option>")
						         .attr("value",response.list_agent[i].AGENT_ACCOUNT)
						         .text(response.list_agent[i].AGENT_NAME)); 
					}
					$('#cb_agentaccount').selectpicker('refresh');

					// cb_basket 
					$('#cb_basket option').remove(); // empty
					for (i = 0; i < response.list_basket.length; i++) { 
						$('#cb_basket').append($("<option></option>")
						         .attr("value",response.list_basket[i].BASKET_CODE)
						         .text(response.list_basket[i].BASKET_NAME)); 
					}
					$('#cb_basket').selectpicker('refresh');
                	$('#myModalHorizontal').modal('show');
                	
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
                }
            });
			var baseURL = "<?php echo base_url(); ?>";
			requestURL = baseURL + 'users/POST_UPDATE_USER_INFO_VIEW';
			 $("#btn_modify").click(function(){
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_account:$('#lb_account').text(),
		                    i_name:$('#tv_name').val(),
		                    i_leverage:$('#cb_leverage').val(),
		                    i_group_name:$('#tv_group').val(),
		                    i_agent_account:$('#cb_agentaccount').val(),
		                    i_status:$('#cb_status').val(),
		                    i_country:$('#tv_country').val(),
		                    i_city:$('#tv_city').val(),
		                    i_state:$('#tv_state').val(),
		                    i_zipcode:$('#tv_zipcode').val(),
		                    i_phone:$('#tv_phone').val(),
		                    i_email:$('#tv_email').val()
		                },
		                success: function (response) {
		                	if(response.result_code == <?php echo VALUE_OK;?>) {
		                		$('#dataTables-example').DataTable().ajax.reload();
		                	}
		                	else {
		                		showAlert(msgErrArray[response.result_code]);
		                	}
		                	 $('#myModalHorizontal').modal('toggle');
		                },
		                error: function (jqXHR, msg, erro) {
		                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
		                	$('#dataTables-example').DataTable().ajax.reload();
		                	 $('#myModalHorizontal').modal('toggle');
		                }
		            });
			 }); 
		}
</script>

