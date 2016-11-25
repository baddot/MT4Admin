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
				<h2><?php echo $arr_ui_string["manager_freemargin_warning_title"]?></h2>
				<h5><?php echo $arr_ui_string["manager_freemargin_warning_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-9 form-group">
				<div id="from-date-container" style="width: 100%;">
	                <table>
	                    <tbody>
	                    <tr>
	                    	<td><?php echo  $arr_ui_string["manager_freemargin_warning_cf"]["0"]?></td>
	                        <td><input type="text"  style="margin-left: 5px;" type="text" class="form-control" value="<?php echo $cnfg["CNFG_VALUE"]?>" id="tv_cf"></input></td>
	                       <td><button class="btn btn-primary" style="margin-left: 10px;" onclick="onClickSaveCF()"><?php echo $arr_ui_string['manager_freemargin_warning_cf'][1];?></button> </td>
	                    </tr>
	                    </tbody>
	                </table>
	            </div>
			</div>
		</div>
		
		<div class="row">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading panel-table-heading-custom">
					<h3 class="panel-title"><?php echo $arr_ui_string["manager_freemargin_warning_title"]?></h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<div id="dataTables-example_wrapper"
							class="dataTables_wrapper form-inline content-loader"
							role="grid">
							<!-- table view -->
							<table
								class="table table-striped table-bordered table-hover dataTable no-footer"
								id="dataTables-example_a"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["manager_freemargin_warning_fields"] as $row ) {
										
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
    	
    	   var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"manager/POST_FREEMARGIN_WARNING_VIEW";
			
			dataTable = $('#dataTables-example_a').dataTable({
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
				"bSort" : false,
			    "ajax": {
			        "url": urlData,
			        "type":"POST"
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "DEAL" , "class": "alignCenter"},
				             { "data": "LOGIN" , "class": "alignCenter"},
				             { "data": "OPEN_TIME" , "class": "alignCenter"},
				             { "data": "TYPE" , "class": "alignCenter"},
				             { "data": "SYMBOL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "OPEN_PRICE" , "class": "alignCenter"},
				             { "data": "SL" , "class": "alignCenter"},
				             { "data": "TP" , "class": "alignCenter"},
				         ]
			});

		
       }
						
		function onClickSaveCF() {
			 var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_CNFG_SAVE';
			 $.ajax({
	                url: requestURL,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_cnfg_value:$('#tv_cf').val()
	                },
	                success: function (response) {
	                	if(response.result_code == <?php echo VALUE_OK;?>) {
	                		showAlert("<?php echo $arr_ui_string['msg_save_ok'];?>");
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
		
</script>

