<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["compare_order_title"]?></h2>
				<h5><?php echo $arr_ui_string["compare_order_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-6">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["compare_order_table_expain"][0]?></h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example_omni"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
									 	 	$i = 0;
												foreach ( $arr_ui_string ["compare_order_omni_fields"] as $row ) {
											
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
				<!--End Advanced Tables -->
			</div>
			<div class="col-md-1">
				<button class="btn btn-primary" onclick="onClickRequest()"><?php echo $arr_ui_string['compare_order_btn_request'];?></button> 
			</div>
			<div class="col-md-5">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["compare_order_table_expain"][1]?></h3>
					</div>
					<div class="panel-body">
						<div class="row" style="text-align: right;padding-right: 10px;">
							<button class="btn btn-primary" onclick="onClickSaveLP()"><?php echo $arr_ui_string['compare_order_btn_save_lp'];?></button> 
							<button class="btn btn-primary" onclick="onClickExportSymbol()"><?php echo $arr_ui_string['btn_title_export'];?></button>
						</div>
						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example_symbol"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
									 	 	$i = 0;
												foreach ( $arr_ui_string ["compare_order_order_fields"] as $row ) {
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
				<!--End Advanced Tables -->
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		
		<div class="row">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading panel-table-heading-custom">
					<h3 class="panel-title"><?php echo $arr_ui_string["compare_order_table_expain"][2]?></h3>
				</div>
				<div class="panel-body">
					<div class="row" style="text-align: right;padding-right: 10px;"> 
							<button class="btn btn-primary" onclick="onClickExportOrder()"><?php echo $arr_ui_string['btn_title_export'];?></button>
						</div>
					<div class="table-responsive">
						<div id="dataTables-example_wrapper"
							class="dataTables_wrapper form-inline content-loader"
							role="grid">
							<!-- table view -->
							<table
								class="table table-striped table-bordered table-hover dataTable no-footer"
								id="dataTables-example_order"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["compare_order_symbol_fields"] as $row ) {
										
													
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
			<!--End Advanced Tables -->
		</div>
		<!-- /. ROW  -->
		<hr />
		
		<div class="row">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading panel-table-heading-custom">
					<h3 class="panel-title"><?php echo $arr_ui_string["compare_order_table_expain"][3]?></h3>
				</div>
				<div class="panel-body">
				<div class="row" style="text-align: right;padding-right: 10px;"> 
							<button class="btn btn-primary" onclick="onClickExportNonOrder()"><?php echo $arr_ui_string['btn_title_export'];?></button>
						</div>
					<div class="table-responsive">
						<div id="dataTables-example_wrapper"
							class="dataTables_wrapper form-inline content-loader"
							role="grid">
							<!-- table view -->
							<table
								class="table table-striped table-bordered table-hover dataTable no-footer"
								id="dataTables-example_nonorder"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["compare_order_nomatch_fields"] as $row ) {
										
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
			<!--End Advanced Tables -->
		</div>
	</div>
	<!-- page-inner -->
</div>

<!-- DATA TABLE SCRIPTS -->
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.js"></script>

<script>

		var dataTable;
		// Array holding selected row IDs
		var rows_selected = [];   
		
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
												
       function onLoad() {
    	   var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"statement/GET_COMPARE_OPENORD_OMNI_SUB";
			
			dataTable = $('#dataTables-example_omni').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"pageLength":5,
				"scrollY":  200,
		        "scrollX": true,
				"info": true,
				"language": {
					  "info": "_START_- _END_(_TOTAL_)",
					  "paginate": {
						  "previous": "<?php echo $arr_ui_string['btn_title_prev'];?>",
						  "next": "<?php echo $arr_ui_string['btn_title_next'];?>"
				      }
				 },
				 "scrollX": false,
			    "ajax": {
			        "url": urlData,
			        "type":"POST"
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "OMNI_VOLUME" },
				             { "data": "OMNI_ACNT" },
				             { "data": "SUB_VOLUME"},
				             { "data": "OMNI_NAME" },
				             { "data": "DIFF_LOTS"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/GET_COMPARE_OPENORDER_SYMBOL";
			
			dataTable = $('#dataTables-example_symbol').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  200,
		        "scrollX": true,
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
			        "type":"POST"
			     },
			     "autoWidth": false,
				 "columns": [
							 { "data":1},
				             { "data": "SYMBOL"},
				             { "data": "INVAST_VOL",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['INVAST_VOL']+"' id='invast_vol' style='width:80px;'/>";
				                     return ddl;
				                }},
				             { "data": "SENSUS_VOL",
					            	 "render": function (data, type, row) {
					                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['SENSUS_VOL']+"' id='sensus_vol'  style='width:80px;'/>";
					                     return ddl;
					                }},
				             { "data": "FBP_VOL"},
				             { "data": "BUY_VOL" },
				             { "data": "SELL_VOL"},
				             { "data": "DIFF_VOL"}
				         ],
				         'columnDefs': [{
				             'targets': 0,
				             'searchable': false,
				             'orderable': false,
				             'width': '1%',
				             'className': 'dt-body-center',
				             'render': function (data, type, full, meta){
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
			   $('#dataTables-example_symbol tbody').on('click', 'input[type="checkbox"]', function(e){
			      var $row = $(this).closest('tr');

			      // Get row data
			      var table = $('#dataTables-example_symbol').DataTable();
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
			   $('#dataTables-example_symbol').on('click', 'tbody td, thead th:first-child', function(e){
			      $(this).parent().find('input[type="checkbox"]').trigger('click');
			   });

			   // Handle click on "Select all" control
			   $('thead input[name="cb_select_all"]').on('click', function(e){
			      if(this.checked){
			         $('#dataTables-example_symbol tbody input[type="checkbox"]:not(:checked)').trigger('click');
			      } else {
			         $('#dataTables-example_symbol tbody input[type="checkbox"]:checked').trigger('click');
			      }

			      // Prevent click event from propagating to parent
			      e.stopPropagation();
			   });

			   // Handle table draw event
			   dataTable.on('draw', function(){
			      // Update state of "Select all" control
			      updateDataTableSelectAllCtrl(dataTable);
			   });
			   

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/GET_COMPARE_LIST_OPENORDER";
			
			dataTable = $('#dataTables-example_order').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"pageLength":5,
				"scrollY":  200,
		        "scrollX": true,
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
			        "type":"POST"
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "TICKET" , "class": "alignCenter"},
				             { "data": "LOGIN" , "class": "alignCenter"},
				             { "data": "MODIFY_TIME" , "class": "alignCenter"},
				             { "data": "TYPE" , "class": "alignCenter"},
				             { "data": "SYMBOL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "OPEN_PRICE" , "class": "alignCenter"},
				             { "data": "SL" , "class": "alignCenter"},
				             { "data": "REASON" , "class": "alignCenter"},
				             { "data": "COMMISSION_AGENT" , "class": "alignCenter"},
				             { "data": "SWAPS" , "class": "alignCenter"},
				             { "data": "PROFIT" , "class": "alignCenter"},
				             { "data": "COMMENT" , "class": "alignCenter"},
				             { "data": "GROUP" , "class": "alignCenter"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/GET_COMPARE_NONMATCH_OPENORDER";
			
			dataTable = $('#dataTables-example_nonorder').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"pageLength":5,
				"scrollY":  200,
		        "scrollX": true,
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
			        "type":"POST"
			     },
			     "bSort" : false,
			     "autoWidth": false,
				 "columns": [
				             { "data": "TICKET" , "class": "alignCenter"},
				             { "data": "LOGIN" , "class": "alignCenter"},
				             { "data": "OPEN_TIME" , "class": "alignCenter"},
				             { "data": "TYPE" , "class": "alignCenter"},
				             { "data": "SYMBOL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "OPEN_PRICE" , "class": "alignCenter"},
				             { "data": "SL" , "class": "alignCenter"},
				             { "data": "REASON" , "class": "alignCenter"},
				             { "data": "COMMISSION_AGENT" , "class": "alignCenter"},
				             { "data": "SWAPS" , "class": "alignCenter"},
				             { "data": "PROFIT" , "class": "alignCenter"},
				             { "data": "COMMENTS" , "class": "alignCenter"},
				             { "data": "SUB_TICKET" , "class": "alignCenter"},
				             { "data": "DEAL_MATCH" , "class": "alignCenter"},
				             { "data": "OP_MATCH" , "class": "alignCenter"},
				             { "data": "VOL_MATCH" , "class": "alignCenter"}
				         ]
			});
       }
						
		function onClickRequest() {
			$('#dataTables-example_omni').DataTable().ajax.reload();
			$('#dataTables-example_symbol').DataTable().ajax.reload();
			$('#dataTables-example_order').DataTable().ajax.reload();
			$('#dataTables-example_nonorder').DataTable().ajax.reload();
		}

		function onClickSaveLP() {
			var baseURL = "<?php echo base_url(); ?>";
			
			 $.each(rows_selected, function(index, rowId){
				 var table = $('#dataTables-example_symbol').DataTable();
				 var data = table.row(rowId).data();
				 var i_symbol = data['SYMBOL'];
				 
				 var tr = table.row(rowId).node();
				 var i_sensus_vol = $(tr).find("#sensus_vol").val();
				 var  i_invast_vol = $(tr).find("#invast_vol").val();
				 
				 var baseURL = "<?php echo base_url(); ?>";
				 requestURL = baseURL + 'statement/POST_COMPARE_SAVE_LPORDER';
					
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_symbol:i_symbol,
		                    i_invast_vol:i_invast_vol,
		                    i_sensus_vol:i_sensus_vol
		                },
		                success: function (response) {
		                	if(response.result_code == <?php echo VALUE_OK;?>) {
		                		$('#dataTables-example_symbol').DataTable().ajax.reload();
		                	}
		                	else {
		                		showAlert(msgErrArray[response.result_code]);
		                	}	
		                },
		                error: function (jqXHR, msg, erro) {
		                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
		                	row_counter = 0;
		                	$('#dataTables-example_symbol').DataTable().ajax.reload();
		                }
		            }); 
		      });
		}

		function onClickExportSymbol() {

			exportExcel(0);
		}

		function exportExcel(type) {
			 var baseURL = "<?php echo base_url(); ?>";
			 requestURL = baseURL + 'statement/POST_EXPORT_EXCEL';
				
			 $.ajax({
	                url: requestURL,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    type:type
	                },
	                success: function (response) {
	                	if(response.result_code == <?php echo VALUE_OK;?>) {
	                		showAlert("<?php echo $arr_ui_string['msg_export_ok'];?>");
	                		$.fileDownload(baseURL+response.result_data["export_url"]);
	                	}
	                	else {
	                		showAlert(msgErrArray[response.result_code]);
	                	}	
	                },
	                error: function (jqXHR, msg, erro) {
	                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
	                }
	            }); 
		}
		
		function onClickExportOrder() {
			exportExcel(1);
		}

		function onClickExportNonOrder() {
			exportExcel(2);
		}
		
</script>

