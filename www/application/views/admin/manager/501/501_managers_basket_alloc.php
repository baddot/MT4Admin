
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
				<h2><?php echo $arr_ui_string["managers_basket_alloc_user_title"]?></h2>
				<h5><?php echo $arr_ui_string["managers_basket_alloc_user_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["managers_basket_alloc_user_title"]?></h3>
					</div>
					<div class="panel-body">
						<div class="row" style="text-align: right;padding-right: 10px;">
							<button class="btn btn-primary" onclick="onClickUpdate()"><?php echo $arr_ui_string['btn_title_update'];?></button> 
						</div>

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
									 	 		$i = 0;
												foreach ( $arr_ui_string ["managers_basket_alloc_user_fields"] as $row ) {
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
			var urlData = baseURL+"manager/POST_MANAGERS_BASKET_ALLOC_VIEW";
			
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
				             { "data": "LOGIN", "class": "alignCenter" },
				             { "data": "NAME"},
				             { "data": "BO_COMPANY_NAME", "class": "alignCenter" },
				             { "data": "GROUP", "class": "alignCenter" },
				             { "data": "ARR_BASKET", "class": "alignCenter",
				               "render": function (data, type, row) {
				                     var ddl = "<select size='1' id='"+row['LOGIN']+"_select' name='"+row['LOGIN']+"_select'>";
				                     for (var i = 0; i < data.length; i++) {
					                     if(row['BASKET_CODE'] == data[i]['BASKET_CODE']) {
					                    	 ddl = ddl + "<option value='"+data[i]['BASKET_CODE']+"' selected>"+data[i]['BASKET_NAME']+"</option>";
					                     }
					                     else {
				                         	ddl = ddl + "<option value='"+data[i]['BASKET_CODE']+"'>"+data[i]['BASKET_NAME']+"</option>";
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
			      var rowId = data['LOGIN'];

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
			var table = $('#dataTables-example').DataTable();
			
			 $('#cb_companyname').on('change', function(){
				    var selected = $(this).find("option:selected").text();
				    selectedCompanyName = selected;
				    if( $(this).find("option:selected").val() == <?php echo VALUE_ALL?>) {
				    	selectedCompanyName = "";
				    }
				 
				    $('#dataTables-example').DataTable().ajax.reload();
				  });
			
		}

	
		function onClickUpdate() {
			var baseURL = "<?php echo base_url(); ?>";
			
			 $.each(rows_selected, function(index, rowId){
				 var login = rowId;
				 var seleced_box_id = "#"+login+"_select";
				 var basket_code =  $(seleced_box_id).val();
				 var baseURL = "<?php echo base_url(); ?>";
				 requestURL = baseURL + 'manager/POST_MANAGERS_BASKET_ALLOC';
					
				 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_basket_code:basket_code,
		                    i_user_account:login
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
			
</script>

