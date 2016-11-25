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
				<h2><?php echo $arr_ui_string["statement_settle_summary_title"]?></h2>
				<h5><?php echo $arr_ui_string["statement_settle_summary_explain"]?></h5>
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
						                    	<td><?php echo  $arr_ui_string["statement_settle_summary_date"]?></td>
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
					<h3 class="panel-title"><?php echo $arr_ui_string["statement_settle_summary_table_expain"][0]?></h3>
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
											foreach ( $arr_ui_string ["statement_settle_summary_fields_1"] as $row ) {
										
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
					<h3 class="panel-title"><?php echo $arr_ui_string["statement_settle_summary_table_expain"][1]?></h3>
				</div>
				<div class="panel-body">
	
					<div class="table-responsive">
						<div id="dataTables-example_wrapper"
							class="dataTables_wrapper form-inline content-loader"
							role="grid">
							<!--End Advanced Tables -->
						<div class="row" style="text-align: right;padding-right: 10px;">
							<button class="btn btn-primary" onclick="onClickSaveBlance()"><?php echo $arr_ui_string['btn_title_save'];?></button> 
							<a class="btn btn-primary" href="<?php echo base_url(); ?>configuration/lp_account_view"><?php echo $arr_ui_string['statement_settle_summary_register_lp_account'];?></a>
						</div>
		
							<!-- table view -->
							<table
								class="table table-striped table-bordered table-hover dataTable no-footer"
								id="dataTables-example_b"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["statement_settle_summary_fields_2"] as $row ) {
										
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
					<h3 class="panel-title"><?php echo $arr_ui_string["statement_settle_summary_table_expain"][2]?></h3>
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
								id="dataTables-example_c"
								aria-describedby="dataTables-example_info">
								<thead>
									<tr>
								 	 <?php
								 	 	$i = 0;
											foreach ( $arr_ui_string ["statement_settle_summary_fields_3"] as $row ) {
										
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

				 startDate  = document.getElementById('fromDate').value;

				 var param = new Array;
				 param['i_trade_dt'] = startDate;
				 param['i_close_yn'] = 'Y';

				 var baseURL = "<?php echo base_url(); ?>";
				 
				 urlData = baseURL+"statement/GET_SETTLE_SUMMARY_A";
				 
				 reloadTable('#dataTables-example_a', urlData, startDate);

				 var urlData = baseURL+"statement/GET_SETTLE_SUMMARY_B";
				 reloadTable('#dataTables-example_c',urlData,  startDate);

				 // reload table2
				 var urlTable2 = baseURL+"statement/POST_LP_BALANCE_VIEW";
				 reloadTable('#dataTables-example_b',urlTable2,  startDate);
				 $(this).datepicker('hide');
			  });
			  
    	   var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"statement/GET_SETTLE_SUMMARY_A";
			
			dataTable = $('#dataTables-example_a').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
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
			        "type":"POST",
			        "data": function(d) {
			            d.i_trade_dt = startDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "CLIENT_NAME" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "SWAP" , "class": "alignCenter"},
				             { "data": "PNL" , "class": "alignCenter"},
				             { "data": "MARKUP_COMM" , "class": "alignCenter"},
				             { "data": "FBP_TOT_PROFIT" , "class": "alignCenter"},
				             { "data": "AGENT_COMM" , "class": "alignCenter"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData = baseURL+"statement/GET_SETTLE_SUMMARY_B";
			
			dataTable = $('#dataTables-example_c').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"pageLength":5,
				 "bSort" : false,
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
			        "data":  function(d) {
			            d.i_trade_dt = startDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "CLIENT_NAME" , "class": "alignCenter"},
				             { "data": "PNL" , "class": "alignCenter"},
				             { "data": "VOLUME" , "class": "alignCenter"},
				             { "data": "SWAP" , "class": "alignCenter"},
				             { "data": "AGENT_COMM" , "class": "alignCenter"},
				             { "data": "MARKUP_COMM" , "class": "alignCenter"},
				             { "data": "FBP_TOT_PROFIT" , "class": "alignCenter"}
				         ]
			});

			baseURL = "<?php echo base_url(); ?>";
			urlData1 = baseURL+"statement/POST_LP_BALANCE_VIEW";
			
			dataTable = $('#dataTables-example_b').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"pageLength":5,
				 "bSort" : false,
				"info": true,
				"language": {
					  "info": "_START_- _END_(_TOTAL_)",
					  "paginate": {
						  "previous": "<?php echo $arr_ui_string['btn_title_prev'];?>",
						  "next": "<?php echo $arr_ui_string['btn_title_next'];?>"
				      }
				 },
			    "ajax": {
			        "url": urlData1,
			        "type":"POST",
			        "data":  function(d) {
			            d.i_dt = startDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "LP_ACCOUNT" , "class": "alignCenter"},
				             { "data": "BUY_VOLUME", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['BUY_VOLUME']+"' id='buy_volumn' name='buy_volumn'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['BUY_VOLUME'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "SELL_VOLUME", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['SELL_VOLUME']+"' id='sell_volumn' name='sell_volumn'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['SELL_VOLUME'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "GROSS_VOLUME", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['GROSS_VOLUME']+"' id='gross_volumn' name='gross_volumn'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['GROSS_VOLUME'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "DEPOSIT", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['DEPOSIT']+"' id='deposit' name='deposit'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['DEPOSIT'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "WITHDRAWAL", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['WITHDRAWAL']+"' id='withdrawal' name='withdrawal'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['WITHDRAWAL'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "PROFIT", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['PROFIT']+"' id='profit' name='profit'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['PROFIT'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "SWAPS", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['SWAPS']+"' id='swap' name='swap'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['SWAPS'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "BALANCE", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['BALANCE']+"' id='balance' name='balance'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['BALANCE'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "FLOATING_PROFIT", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['FLOATING_PROFIT']+"' id='floating_profit' name='floating_profit'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['FLOATING_PROFIT'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "PREV_EQUITY", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['PREV_EQUITY']+"' id='prev_equity' name='prev_equity'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['PREV_EQUITY'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "CURR_EQUITY", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['CURR_EQUITY']+"' id='curr_equity' name='curr_equity'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['CURR_EQUITY'];
				                     }
				                     return ddl;
				                }
					           },
				           { "data": "DIFF_EQUITY", "class": "alignCenter",
				            	 "render": function (data, type, row) {
				                     var ddl = "<input  type="+"text"+" class="+"form-control"+" value='"+row['DIFF_EQUITY']+"' id='diff_equity' name='diff_equity'/>";
				                     if(row['LP_ACCOUNT'] == "SUM") {
					                     ddl = row['DIFF_EQUITY'];
				                     }
				                     return ddl;
				                }
					           }
           
				         ]
			});
       }
						
	   function onClickSaveBlance() {
		  var  baseURL = "<?php echo base_url(); ?>";
		  var urlData1 = baseURL+"statement/POST_LP_BALANCE_SAVE";
		  var table = $('#dataTables-example_b').DataTable();
		  var rowCount = $('#dataTables-example_b tr').length;
			
		  for(var idx = 1; idx < (rowCount - 1); idx++) {
			 var rowId = idx-1;
			 var data = table.row(rowId).data();
			 var i_lp_account = data['LP_ACCOUNT'];

			 if(i_lp_account == "SUM") {
				 continue;
			 }
			 
			 var i_dt = $('#fromDate').val();
			 var tr = table.row(rowId).node();
			 var i_buy_volume = $(tr).find("#buy_volumn").val();
			 var i_sell_volume = $(tr).find("#sell_volumn").val();
			 var i_gross_volume = $(tr).find("#gross_volumn").val();
			 var i_withdrawal = $(tr).find("#withdrawal").val();
			 var i_deposit = $(tr).find("#deposit").val();
			 var i_profit = $(tr).find("#profit").val();
			 var i_swaps = $(tr).find("#swap").val();
			 var i_balance = $(tr).find("#balance").val();
			 var i_floating_profit = $(tr).find("#floating_profit").val();
			 var i_prev_equity = $(tr).find("#prev_equity").val();
			 var i_curr_equity = $(tr).find("#curr_equity").val();

			 $.ajax({
	                url: urlData1,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_dt:i_dt,
	                    i_lp_account:i_lp_account,
	                    i_buy_volume:i_buy_volume,
	                    i_sell_volume:i_sell_volume,
	                    i_gross_volume:i_gross_volume,
	                    i_withdrawal:i_withdrawal,
	                    i_deposit:i_deposit,
	                    i_profit:i_profit,
	                    i_swaps:i_swaps,
	                    i_balance:i_balance,
	                    i_floating_profit:i_floating_profit,
	                    i_prev_equity:i_prev_equity,
	                    i_curr_equity:i_curr_equity
	                },
	                success: function (response) {
	                	if(response.result_code == <?php echo VALUE_OK;?>) {
	                		row_counter = 0;
	                		$('#dataTables-example_b').DataTable().ajax.reload();
	                	}
	                	else {
	                		showAlert(msgErrArray[response.result_code]);
	                	}	
	                },
	                error: function (jqXHR, msg, erro) {
	                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
	                	row_counter = 0;
	                	$('#dataTables-example_b').DataTable().ajax.reload();
	                }
	            }); 
		  }
	   }
		
</script>

