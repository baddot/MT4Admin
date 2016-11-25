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
				<h2><?php echo $arr_ui_string["statement_closed_orders_title"]?></h2>
				<h5><?php echo $arr_ui_string["statement_closed_orders_explain"]?></h5>
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
						                    	<td><?php echo  $arr_ui_string["statement_closed_orders_date"]?></td>
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
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading panel-table-heading-custom">
					<h3 class="panel-title"><?php echo $arr_ui_string["statement_closed_orders_table_expain"][0]?></h3>
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
											foreach ( $arr_ui_string ["statement_closed_orders_fields_1"] as $row ) {
										
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
					<h3 class="panel-title"><?php echo $arr_ui_string["statement_closed_orders_table_expain"][1]?></h3>
				</div>
				<div class="panel-body">
				<!-- <div class="row" style="text-align: right;padding-right: 10px;"> 
							<button class="btn btn-primary" onclick="onClickExportNonOrder()"><?php echo $arr_ui_string['btn_title_export'];?></button>
						</div>  -->
					<div class="table-responsive">
						<div id="dataTables-example_wrapper"
							class="dataTables_wrapper form-inline content-loader"
							role="grid">
							<!-- table view -->
							<table
								class="table table-striped table-bordered table-hover dataTable no-footer"
								id="dataTables-example_2"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["statement_closed_orders_fields_2"] as $row ) {
										
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

	var startDate = ""
	$('#from-date-container input').datepicker({
	    format: 'yyyymmdd'
	});

	function reloadTable(tableId, url, startDate) {
		 $.ajax({
           url: url,
           type: "POST", // To protect sensitive data
           data: {
               "i_trade_dt":startDate,
               "i_close_yn":"Y"
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
				 param['i_trade_dt'] = startDate;
				 param['i_close_yn'] = 'Y';

				 var baseURL = "<?php echo base_url(); ?>";
				 
				 urlData = baseURL+"statement/GET_SETTLE_SUMMARY_A_GROUP";
				 
				 reloadTable('#dataTables-example_1', urlData, startDate);

				 var urlData = baseURL+"statement/GET_CLOSED_ORDERS_VIEW";
				 reloadTable('#dataTables-example_2',urlData,  startDate);

				 $(this).datepicker('hide');
				 // $('#dataTables-example_1').DataTable().ajax.reload();
				 // $('#dataTables-example_2').DataTable().ajax.reload();
			  });
			  
    	   var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"statement/GET_SETTLE_SUMMARY_A_GROUP";
			
			dataTable = $('#dataTables-example_1').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  200,
		        "scrollX": true,
				"pageLength":5,
				"info": true,
				"bSort":false,
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
			            d.i_close_yn = "Y";
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "GROUP_NAME" , "class": "alignCenter"},
				             { "data": "PNL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "SWAP" , "class": "alignCenter"},
				             { "data": "AGENT_COMM" , "class": "alignCenter"},
				             { "data": "MARKUP_COMM" , "class": "alignCenter"},
				             { "data": "FBP_TOT_PROFIT" , "class": "alignCenter"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/GET_CLOSED_ORDERS_VIEW";
			
			dataTable = $('#dataTables-example_2').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  200,
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
				             { "data": "TICKET" , "class": "alignCenter"},
				             { "data": "LOGIN" , "class": "alignCenter"},
				             { "data": "OPEN_TIME" , "class": "alignCenter"},
				             { "data": "CMD" , "class": "alignCenter"},
				             { "data": "SYMBOL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "CLOSE_TIME" , "class": "alignCenter"},
				             { "data": "FIXED_CLOSED_PRICE" , "class": "alignCenter"},
				             { "data": "SWAPS" , "class": "alignCenter"},
				             { "data": "CONV2" , "class": "alignCenter"},
				             { "data": "FIXED_PROFIT" , "class": "alignCenter"},
				             { "data": "GROUP" , "class": "alignCenter"},
				             { "data": "TOTAL_FBP_MARKUP" , "class": "alignCenter"},
				             { "data": "AGENT_COMM" , "class": "alignCenter"}
				         ]
			});
       }
						
		function onClickExportNonOrder() {
			exportExcel(2);
		}
		
</script>

