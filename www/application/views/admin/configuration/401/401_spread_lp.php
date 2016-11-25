<?php require_once '401_spread_lp_create.php';?>

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
				<h2><?php echo $arr_ui_string["configuration_spread_lp_title"]?></h2>
				<h5><?php echo $arr_ui_string["configuration_spread_lp_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["configuration_spread_lp_title"]?></h3>
					</div>
					<div class="panel-body">
						<div class="row" style="text-align: right;padding-right: 10px;">
							<button class="btn btn-primary" onclick="onClickUpdate()"><?php echo $arr_ui_string['btn_title_update'];?></button> 
							<button class="btn btn-primary" onclick="onClickRegister()"><?php echo $arr_ui_string['btn_title_register'];?></button>
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
												foreach ( $arr_ui_string ["configuration_spread_lp_fields"] as $row ) {
													if($i == 0) {
														echo '<th><input type="checkbox" class="editor-active" id="cb_check_all" name="cb_select_all"/></th>';
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

		
		function loadTable() {

			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"configuration/POST_SPREAD_LP_VIEW";
			
			dataTable = $('#dataTables-example').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": true,
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
				 "columns":[ 
				             { "data":1},
				             { "data": "LP_NAME", "class": "alignCenter" },
				             { "data": "SYMBOL"},
				             { "data": "MARKUP_BID", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['MARKUP_BID']+"' id='"+row['SYMBOL']+row['LP_ID']+"_markup_bid' name='"+row['SYMBOL']+row['LP_ID']+"_markup_bid'/>";
				                     return ddl;
				                }
					           },
				             { "data": "MARKUP_ASK", "class": "alignCenter",
					            	 "render": function (data, type, row) {
					                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['MARKUP_ASK']+"' id='"+row['SYMBOL']+row['LP_ID']+"_markup_ask' name='"+row['SYMBOL']+row['LP_ID']+"_markup_ask'/>";
					                     return ddl;
					                } },
				             { "data": "ENABLED", "class": "alignCenter",
				               "render": function (data, type, row) {
				                     var ddl = "<select size='1' id='"+row['SYMBOL']+"_select' name='"+row['SYMBOL']+row['LP_ID']+"_select'>";
				                     for(i = 0; i < 2; i ++) {
											if( i == 0) {
												if(row['ENABLED'] == 'Y') {
													ddl += '<option value="Y">Y</option>';
												}
												else {
													ddl += '<option value="Y" selected>Y</option>';
												}
											}
											else {
												if(row['ENABLED'] != 'Y') {
													ddl += '<option value="N" selected>N</option>';
												}
												else {
													ddl += '<option value="N">N</option>';
												}
											}
										}
				                     ddl += "</select>";
				                     return ddl;
				                }
					          }
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

			 var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'configuration/POST_SPREAD_LP_CREATE';
				 $("#btn_create").click(function(){
					 $.ajax({
			                url: requestURL,
			                type: "POST", // To protect sensitive data
			                data: {
			                    ajax: true,
			                    i_lp_id:$('#cb_create_lp_name').val(),
			                    i_symbol:$('#tv_create_symbol').val(),
			                    i_markup_bid:$('#tv_create_markup_bid').val(),
			                    i_markup_ask:$('#tv_create_markup_ask').val()
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

	
		function onClickUpdate() {
			var baseURL = "<?php echo base_url(); ?>";
			
			 $.each(rows_selected, function(index, rowId){
				  var table = $('#dataTables-example').DataTable();
				 var data = table.row(rowId).data();
				 var symbol = data['SYMBOL'];
				 var i_lp_id = data['LP_ID'];
				 var i_markup_bid = $("#"+symbol+i_lp_id+"_markup_bid").val();
				 var i_markup_mask = $("#"+symbol+i_lp_id+"_markup_mask").val();
				 var i_enabled = $("#"+symbol+i_lp_id+"_select").val();
				 
				 var baseURL = "<?php echo base_url(); ?>";
				 requestURL = baseURL + 'configuration/POST_SPREAD_LP_MODIFY';
					
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_lp_id:i_lp_id,
		                    i_symbol:symbol,
		                    i_markup_bid:i_markup_bid,
		                    i_markup_ask:i_markup_mask,
		                    i_enabled:i_enabled
		                },
		                success: function (response) {
		                	if(response.result_code == <?php echo VALUE_OK;?>) {
		                		$('#dataTables-example').DataTable().ajax.reload();
		                	}
		                	else {
		                		showAlert(msgErrArray[response.result_code]);
		                	}	
		                },
		                error: function (jqXHR, msg, erro) {
		                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
		                	$('#dataTables-example').DataTable().ajax.reload();
		                }
		            }); 
		      });
		}

		function onClickRegister() {
			var baseURL = "<?php echo base_url(); ?>";
			 $('#myCreateModalHorizontal').modal('show');
			 
			
		}
</script>

