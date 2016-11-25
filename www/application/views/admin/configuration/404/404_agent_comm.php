<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />
	
<link href="<?php echo base_url(); ?>assets/css/import_file.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/import_file.js"></script>

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["configuration_agent_comm_title"]?></h2>
				<h5><?php echo $arr_ui_string["configuration_agent_comm_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["configuration_agent_comm_title"]?></h3>
					</div>
					<div class="panel-body">
						<div class="row" style="padding: 10px;">
							<div class="import-file" id="import_file"> </div> 
							<a class="btn btn-primary" href="<?php echo base_url(); ?>outputs/AGENT_COMM.csv" style="margin-top: 5px;"><?php echo $arr_ui_string['btn_title_download_import_template'];?></a>
							<button class="btn btn-primary" onclick="onClickUpdate()"  style="margin-top: 5px; text-align: right;"><?php echo $arr_ui_string['btn_title_update'];?></button>
						</div>

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
									 	 		$i = 0;
												foreach ( $arr_ui_string ["configuration_agent_comm_fields"] as $row ) {
													if($i == 0) {
														echo '<th><input type="checkbox" class="editor-active" id="cb_check_all" name="cb_select_all"/></th>';
														echo "<th>$row</th>";
													}
													else {
														echo "<th>$row</th>";
													}
													$i++;
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
		var selectedCompanyName = "";
		var dataTable;
		// Array holding selected row IDs
		var rows_selected = [];

		var row_counter = 0;
		   
		//
		// Updates "Select all" control in a data table
		//
		function updateDataTableSelectAllCtrl(table){
		   var $table             = table.table().node();
		   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
		   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
		   var chkbox_select_all  = $('thead input[name="cb_select_all"]', $table).get(0);

		   // If none of the checkboxes are checked
		   if($chkbox_checked.length === 0){
		      chkbox_select_all.checked = false;
		      if('indeterminate' in chkbox_select_all){
		         chkbox_select_all.indeterminate = false;
		      }

		   // If all of the checkboxes are checked
		   } else if ($chkbox_checked.length === $chkbox_all.length){
		      chkbox_select_all.checked = true;
		      if('indeterminate' in chkbox_select_all){
		         chkbox_select_all.indeterminate = false;
		      }

		   // If some of the checkboxes are checked
		   } else {
		      chkbox_select_all.checked = true;
		      if('indeterminate' in chkbox_select_all){
		         chkbox_select_all.indeterminate = true;
		      }
		   }
		}

		 $('#import_file').importfile( {
		    	btn_title: '<?php echo $arr_ui_string["btn_title_import"]?>',
		    	import_url: 'POST_IMPORT_AGENT_COMM_EXCEL',
		    	msg_fail: '<?php echo $arr_ui_string["msg_fail_network"]?>',
		    	msg_success: '<?php echo $arr_ui_string["msg_import_ok"]?>',
		    	reload_function:function (){
		    		$('#dataTables-example').DataTable().ajax.reload();
		    	}
		    });
		
		function loadTable() {

			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"configuration/POST_AGENT_COMM_VIEW";
			
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
			            d.i_company_name = selectedCompanyName;
			        }
			     },
			     "autoWidth": false,
				 "columns":[ 
				             { "data":1},
				             { "data": "GROUP_NAME", "class": "alignCenter" },
				             { "data": "BO_TOT_AGENT_COMM", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['BO_TOT_AGENT_COMM']+"' id='agent_comm' name='agent_comm'/>";
				                     return ddl;
				                }
					           },
					           { "data": "SPREAD_DIFF"}
				         ],
		         'columnDefs': [{
		             'targets': 0,
		             'searchable': false,
		             'orderable': false,
		             'width': '1%',
		             'className': 'dt-body-center',
		             'render': function (data, type, full, meta){
		            	 row_counter++;
		                 return '<input type="checkbox">';
		             }
		          }],
		          'order': [[1, 'asc']],
		          'rowCallback': function(row, data, dataIndex){
		             // Get row ID
		             var rowId = data[0];

		             // If row ID is in the list of selected row IDs
		             if($.inArray(rowId, rows_selected) !== -1){
		                $(row).find('input[type="checkbox"]').prop('checked', true);
		                $(row).addClass('selected');
		             }
		          }
			});

			// Handle click on checkbox
			   $('#dataTables-example tbody').on('click', 'input[type="checkbox"]', function(e){
			      var $row = $(this).closest('tr');

			      // Get row data
			      var table = $('#dataTables-example').DataTable();
			      var data = table.row($row).data();

			      // Get row ID
			      var rowId = $row.index();

			      // Determine whether row ID is in the list of selected row IDs 
			      var index = $.inArray(rowId, rows_selected);

			      // If checkbox is checked and row ID is not in list of selected row IDs
			      if(this.checked && index === -1){
			         rows_selected.push(rowId);

			      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
			      } else if (!this.checked && index !== -1){
			         rows_selected.splice(index, 1);
			      }

			      if(this.checked){
			         $row.addClass('selected');
			      } else {
			         $row.removeClass('selected');
			      }

			      // Update state of "Select all" control
			      updateDataTableSelectAllCtrl(table);

			      // Prevent click event from propagating to parent
			      e.stopPropagation();
			   });

			   // Handle click on table cells with checkboxes
			   $('#dataTables-example').on('click', 'tbody td, thead th:first-child', function(e){
			      $(this).parent().find('input[type="checkbox"]').trigger('click');
			   });

			   // Handle click on "Select all" control
			   $('thead input[name="cb_select_all"]').on('click', function(e){
			      if(this.checked){
			         $('#dataTables-example tbody input[type="checkbox"]:not(:checked)').trigger('click');
			      } else {
			         $('#dataTables-example tbody input[type="checkbox"]:checked').trigger('click');
			      }

			      // Prevent click event from propagating to parent
			      e.stopPropagation();
			   });

			   // Handle table draw event
			   dataTable.on('draw', function(){
			      // Update state of "Select all" control
			      updateDataTableSelectAllCtrl(dataTable);
			   });

			   /*
			   // Iterate over all selected checkboxes
			     
			   */
		}
		
		function onLoad() {
			loadTable();
		}

	
		function onClickUpdate() {
			var baseURL = "<?php echo base_url(); ?>";
			
			 $.each(rows_selected, function(index, rowId){
				 var table = $('#dataTables-example').DataTable();
				 var data = table.row(rowId).data();
				 var i_group_idx = data['IDX'];
				 var i_spread_diff = data['SPREAD_DIFF'];
				 var i_group_name = data['GROUP_NAME'];

				 var tr = table.row(rowId).node();
				 var i_agent_comm = $(tr).find("#agent_comm").val();
				 
				 var baseURL = "<?php echo base_url(); ?>";
				 requestURL = baseURL + 'configuration/POST_AGENT_COMM_SAVE';
					
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_spread_diff:i_spread_diff,
		                    i_group_idx:i_group_idx,
		                    i_agent_comm:i_agent_comm,
		                    i_group_name:i_group_name
		                },
		                success: function (response) {
		                	if(response.result_code == <?php echo VALUE_OK;?>) {
		                		row_counter = 0;
		                		$('#dataTables-example').DataTable().ajax.reload();
		                	}
		                	else {
		                		showAlert(msgErrArray[response.result_code]);
		                	}	
		                },
		                error: function (jqXHR, msg, erro) {
		                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
		                	row_counter = 0;
		                	$('#dataTables-example').DataTable().ajax.reload();
		                }
		            }); 
		      });
		}

		function onClickRegister() {
			var baseURL = "<?php echo base_url(); ?>";
			 $('#myCreateModalHorizontal').modal('show');
			 
			 var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'configuration/POST_MARKUP_BRIDGE_CREATE';
				 $("#btn_create").click(function(){
					 $.ajax({
			                url: requestURL,
			                type: "POST", // To protect sensitive data
			                data: {
			                    ajax: true,
			                    i_lp_id:$('#cb_create_lp_name').val(),
			                    i_symbol:$('#tv_create_symbol').val(),
			                    i_markup_bid:$('#tv_create_markup_bid').val(),
			                    i_markup_ask:$('#tv_create_markup_ask').val(),
			                    i_swap_short:$('#tv_create_swap_short').val(),
			                    i_swap_long:$('#tv_create_swap_long').val(),
			                    i_digits:$('#cb_create_digits').val()
			                },
			                success: function (response) {
			                	if(response.result_code == <?php echo VALUE_OK;?>) {
			                		row_counter = 0;
			                		$('#dataTables-example').DataTable().ajax.reload();
			                	}
			                	else {
			                		showAlert(msgErrArray[response.result_code]);
			                	}	
			                	 $('#myCreateModalHorizontal').modal('toggle');
			                },
			                error: function (jqXHR, msg, erro) {
			                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
			                	row_counter = 0;
			                	$('#dataTables-example').DataTable().ajax.reload();
			                	$('#myCreateModalHorizontal').modal('toggle');
			                }
			            });
				 }); 
		}
</script>

