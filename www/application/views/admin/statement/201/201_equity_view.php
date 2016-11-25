<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["statement_equip_view_title"]?></h2>
				<h5><?php echo $arr_ui_string["statement_equip_view_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<form class="form-horizontal" role="form">
								<div class="col-md-9 form-group">
									<div id="from-date-container" style="width: 100%;">
						                <table>
						                    <tbody>
						                    <tr>
						                    	<td><?php echo  $arr_ui_string["statement_equip_view_date"]?></td>
						                        <td><input type="text"  style="margin-left: 5px;" type="text" class="form-control" value="<?php echo $startDate?>" id="fromDate"/></td>
						                       
						                    </tr>
						                    </tbody>
						                </table>
						            </div>
								</div>
			</form>
			<!-- table view -->
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["statement_equip_view_explain"]?></h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example_1"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
									 	 	$i = 0;
												foreach ( $arr_ui_string ["statement_equip_view_fields"] as $row ) {
											
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
			
			<div class="col-md-6">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["statement_equip_view_cash"]?></h3>
					</div>
					<div class="panel-body">
						<div class="row" style="text-align: right;padding-right: 10px;">
							<button class="btn btn-primary" onclick="onClickSaveCash()"><?php echo $arr_ui_string['btn_title_save'];?></button> 
						</div>
						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<!-- table view -->
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="dataTables-example_cash"
									aria-describedby="dataTables-example_info">
									<thead>
										<tr>
									 	 <?php
									 	 	$i = 0;
												foreach ( $arr_ui_string ["statement_equip_view_cash_fields"] as $row ) {
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
	</div>
	<!-- page-inner -->
</div>

<!-- DATA TABLE SCRIPTS -->
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script
	src="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.js"></script>

<script>

	var startDate = ""
	$('#from-date-container input').datepicker({
	    format: 'yyyymmdd'
	});

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
	
	function reloadTable(tableId, url, startDate) {
		 $.ajax({
            url: url,
            type: "POST", // To protect sensitive data
            data: {
                "i_trade_dt":startDate
                },
            success: function (response) {
            	table = $(tableId).dataTable();
            	oSettings = table.fnSettings();
            	table.fnClearTable(this);
            	data = response.data;
            	for(var i = 0; i < data.length; i++) {
                	table.oApi._fnAddData(oSettings, data[i]);
            	}
            	oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            	table.fnDraw();
            },
            error: function (jqXHR, msg, erro) {
            	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
            	$(tableId).DataTable().ajax.reload();
            }
        });
	}
	
    function onLoad() {
    	   $('#fromDate').on('change', function(){
				 startDate  = document.getElementById('fromDate').value;
				 var param = new Array;
				 var baseURL = "<?php echo base_url(); ?>";
				 
				 urlData = baseURL+"statement/POST_EQUITY_VIEW";
				 
				 reloadTable('#dataTables-example_1', urlData, startDate);
				 
				 urlData = baseURL+"statement/POST_CASH_VIEW";
				 reloadTable('#dataTables-example_cash', urlData, startDate);
				 $(this).datepicker('hide');
			  });
			  
    	   var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"statement/POST_EQUITY_VIEW";
			
			dataTable = $('#dataTables-example_1').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  400,
		        "scrollX": true,
				"pageLength":5,
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
			            d.i_trade_dt = startDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "USER_COMPANY" , "class": "alignCenter"},
				             { "data": "USER_ACCOUNT" , "class": "alignCenter"},
				             { "data": "PREV_EQUITY" , "class": "alignCenter"},
				             { "data": "EQUITY" , "class": "alignCenter"},
				             { "data": "DIFF_EQUITY" , "class": "alignCenter"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/POST_CASH_VIEW";
			
			dataTable = $('#dataTables-example_cash').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  400,
		        "scrollX": true,
				"pageLength":5,
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
			     "bSort":false,
				 "columns": [
							 { "data":1},
				             { "data": "TYPE_NAME"},
				             { "data": "ACCOUNT_NAME"},
				             { "data": "PREV_AMOUNT"},
				             { "data": "AMOUNT",
					            	 "render": function (data, type, row) {
					                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['AMOUNT']+"' id='ammount'  style='width:80px;'/>";
					                     return ddl;
					                }},
				             { "data": "DIFF_AMOUNT"}
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
			   $('#dataTables-example_cash tbody').on('click', 'input[type="checkbox"]', function(e){
			      var $row = $(this).closest('tr');

			      // Get row data
			      var table = $('#dataTables-example_cash').DataTable();
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
			   $('#dataTables-example_cash').on('click', 'tbody td, thead th:first-child', function(e){
			      $(this).parent().find('input[type="checkbox"]').trigger('click');
			   });

			   // Handle click on "Select all" control
			   $('thead input[name="cb_select_all"]').on('click', function(e){
			      if(this.checked){
			         $('#dataTables-example_cash tbody input[type="checkbox"]:not(:checked)').trigger('click');
			      } else {
			         $('#dataTables-example_cash tbody input[type="checkbox"]:checked').trigger('click');
			      }

			      // Prevent click event from propagating to parent
			      e.stopPropagation();
			   });

			   // Handle table draw event
			   dataTable.on('draw', function(){
			      // Update state of "Select all" control
			      updateDataTableSelectAllCtrl(dataTable);
			   });
        }
					
		function onClickSaveCash() {
			var baseURL = "<?php echo base_url(); ?>";
			
			 $.each(rows_selected, function(index, rowId){
				 var table = $('#dataTables-example_cash').DataTable();
				 var data = table.row(rowId).data();
				 var i_trade_dt = $('#fromDate').val();
				 var i_type_name = data['TYPE_NAME'];
				 var i_account_name = data['ACCOUNT_NAME'];

				 var tr = table.row(rowId).node();
				 var i_amount = $(tr).find("#ammount").val();
				 
				 
				 var baseURL = "<?php echo base_url(); ?>";
				 requestURL = baseURL + 'statement/POST_CASH_SAVE';
					
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_trade_dt:i_trade_dt,
		                    i_type_name:i_type_name,
		                    i_account_name:i_account_name,
		                    i_amount:i_amount
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
</script>

