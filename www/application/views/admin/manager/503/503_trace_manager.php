
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
				<h2>Trace Manager </h2>
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
									<label class="col-md-3 control-label" for="textinput" style="padding-left: 0px;"> <?php echo $arr_ui_string["manager_info_managername"]?></label>
									<div class="col-md-3">
										<select class="selectpicker" id="cb_managername"
											data-width="auto">
		            							<?php
																$arr2 = $list_manager;
																echo '<option value="'.VALUE_ALL.'">' . $arr_ui_string["btn_select_all"] . '</option>';
																for($i = 0; $i < count ( $arr2 ); $i++) {
																	$manager = $arr2 [$i];
																	echo '<option value="'.$manager['MANAGER_ID'].'">' . $manager['MANAGER_NAME'] . '</option>';
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
												foreach ( $arr_ui_string ["manager_trace_fields"] as $row ) {
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
		//var selectedCompanyName = "";
		var selectedManagerName = "";

		function loadTable() {

			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"manager/POST_TRAC_MANAGER_VIEW";
			
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
			            	d.i_from_dt = 20160124;
			            	d.i_to_dt = 20160324;
			            	d.i_target_company_name = '';
			            	d.i_target_manager_id = selectedManagerName;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "DT", "class": "alignCenter" },
				             { "data": "LAST_UPDATE", "class": "alignCenter" },
				             { "data": "SEQNO", "class": "alignCenter" },
				             { "data": "MANAGER_NAME", "class": "alignCenter" },
				             { "data": "COMPANY_NAME", "class": "alignCenter" },
				             { "data": "JOB_TITLE", "class": "alignCenter" },
				             { "data": "JOB_DETAIL", "class": "alignCenter" }
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

			 /*$('#cb_companyname').on('change', function(){
				    var selected = $(this).find("option:selected").text();
				    selectedCompanyName = selected;
				    if( $(this).find("option:selected").val() == <?php echo VALUE_ALL?>) {
				    	selectedCompanyName = "";
				    }
				 
				    $('#dataTables-example').DataTable().ajax.reload();
				  });*/
				  
			  $('#cb_managername').on('change', function(){
			    var selected = $(this).find("option:selected").text();
			    selectedManagerName = selected;
			    if( $(this).find("option:selected").val() == <?php echo VALUE_ALL?>) {
			    	selectedManagerName = "";
			    }
			 
			    $('#dataTables-example').DataTable().ajax.reload();
			  });
			
		}

		

		
			
</script>

