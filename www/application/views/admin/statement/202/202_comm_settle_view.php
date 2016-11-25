
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["common_settle_view_title"]?></h2>
				<h5><?php echo $arr_ui_string["common_settle_view_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["common_settle_view_title"]?></h3>
					</div>
					<div class="panel-body">

						<div class="table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<form class="form-horizontal" role="form">
								<div class="col-md-4 form-group">
									<label class="col-md-3 control-label" for="textinput" style="padding-left: 0px;"> <?php echo $arr_ui_string["common_settle_view_search_fields"][0]?></label>
									<div class="col-md-3">
										<select class="selectpicker" id="cb_basket"
											data-width="auto">
		            							<?php
																$arr = $list_basket;
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company['BASKET_CODE'].'">' . $company['BASKET_NAME'] . '</option>';
																}
																?>
                          				</select>
									</div>
								</div>
								
								<div class="col-md-8 form-group">
									<label class="col-md-3 control-label" for="textinput" style="padding-left: 0px;"> <?php echo $arr_ui_string["common_settle_view_search_fields"][1]?></label>
									<div id="from-date-container" style="width: 100%;">
						                <table>
						                    <tbody>
						                    <tr>
						                        <td><input type="text" type="text" class="form-control" value="<?php echo $startDate?>" id="fromDate"/></td>
						                        <td><label> ~ </label></td>
						                        <td><input type="text" type="text" class="form-control"  value="<?php echo $endDate?>" id="toDate"/><td>
						                        <td><button type="button" class="btn btn-default  btn-sm" onclick="onClickSearch()" style="margin-left: 5px;"> <?php echo $arr_ui_string["btn_title_search"]?></button></td>
						                    </tr>
						                    </tbody>
						                </table>
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
												foreach ( $arr_ui_string ["common_settle_view_fields"] as $row ) {
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
		<div class="row" style="text-align: right;padding-right: 10px;">
			<button class="btn btn-primary" onclick="onClickRegister()"><?php echo $arr_ui_string['btn_title_register'];?></button> 
		</div>
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
		var selectedBasketCode = -1;
		var selectedBasketName = "";


	    $('#from-date-container input').datepicker({
	        format: 'yyyymmdd'
	    });
	    $('#to-date-container input').datepicker({
	        format: 'yyyymmdd'
	    });

		function loadTable() {

			var baseURL = "<?php echo base_url(); ?>";
			var urlData = baseURL+"statement/POST_COMM_SETTLE_VIEW";
			
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
			            var startDate = document.getElementById('fromDate').value;
			            var endDate = document.getElementById('toDate').value;
			            d.i_basket_code = selectedBasketCode;
			            d.i_from = startDate;
			            d.i_to = endDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": selectedBasketName , "class": "alignCenter"},
				             { "data": "MT4_MARK_UP", "class": "alignCenter" },
				             { "data": "MT4_SPREAD", "class": "alignCenter" },
				             { "data": "TOT_AGENT_COMM","class": "alignRight"  },
				             { "data": "IB1","class": "alignRight" },
				             { "data": "IB2","class": "alignRight" },
				             { "data": "IB3","class": "alignRight" },
				             { "data": "IB4","class": "alignRight" },
				             { "data": "IB5","class": "alignRight" },
				             { "data": "IB6","class": "alignRight" },
				             { "data": "IB7","class": "alignRight" },
				             { "data": "IB8","class": "alignRight" },
				             { "data": "IB9","class": "alignRight" },
				             { "data": "IB10","class": "alignRight" },
				             { "data": "IB11","class": "alignRight" },
				             { "data": "IB12","class": "alignRight" },
				             { "data": "IB13","class": "alignRight" },
				             { "data": "IB14","class": "alignRight" },
				             { "data": "IB15","class": "alignRight" },
				             { "data": "IB16","class": "alignRight" },
				             { "data": "IB17","class": "alignRight" },
				             { "data": "IB18","class": "alignRight" },
				             { "data": "IB19","class": "alignRight" },
				             { "data": "IB20","class": "alignRight" }
				         ]
			});
		}
		
		function onLoad() {
			loadTable();
			var table = $('#dataTables-example').DataTable();
			$('#dataTables-example tbody').on('click', 'tr', function () {
		        var data = table.row( this ).data();
		        window.showUpdateDialog(data);
		        $(this).datepicker('hide');
		    } );

			 $('#cb_companyname').on('change', function(){
				    var selected = $(this).find("option:selected").val();
				    selectedBasketCode = selected;
				    selectedBasketName = $(this).find("option:selected").text();
				    $('#dataTables-example').DataTable().ajax.reload();
				  });
			
		}

		function onClickSearch() {
			 $('#dataTables-example').DataTable().ajax.reload();
		}
			
</script>

