
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
				<h2><?php echo $arr_ui_string["trade_report_title"]?></h2>
				<h5><?php echo $arr_ui_string["trade_report_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["trade_report_title"]?></h3>
					</div>
					<div class="panel-body">
						<div class="col-md-3 form-group">
						   <div class="panel panel-default" style="padding-left: 10px;text-align: center;"">
							<div class="panel-heading"><?php echo $arr_ui_string["trade_report_search_fields"][0]?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable" style="max-height: 500px;">
									<table class="table table-bordered table-scrollable"  id="tb_account">
										<tbody id="list">
	                             	  <?php
										$cnt = count ( $list_account );
									
										foreach ( $list_account as $row ) {
											echo '<tr  value="'.$row['LOGIN'].'" style="text-align: left;">';
											echo '<td value="'.$row['LOGIN'].'">' . $row['LOGIN']."/".$row ['NAME'] . '</td>';
											echo '</tr>';
										}
										?>
	                      		      </tbody>
									</table>
								</div>
							</div>
							</div>
						</div>

						<div class="col-md-9 table-responsive">
							<div id="dataTables-example_wrapper"
								class="dataTables_wrapper form-inline content-loader"
								role="grid">
								<form class="form-horizontal" role="form">
								<div class="col-md-9 form-group">
									<label class="col-md-2 control-label" for="textinput" style="padding-left: 0px;"> <?php echo $arr_ui_string["trade_report_search_fields"][1]?></label>
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
												foreach ( $arr_ui_string ["trade_report_fields"] as $row ) {
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
			var urlData = baseURL+"trade/POST_TRADE_REPORT_VIEW";
			
			dataTable = $('#dataTables-example').dataTable({
				"processing": true,
				"lengthChange": false,
				"searching": false,
				"paging": false,
				"scrollY":  500,
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
			            var startDate = document.getElementById('fromDate').value;
			            var endDate = document.getElementById('toDate').value;
			            d.i_account = selectedBasketCode;
			            d.i_from = startDate;
			            d.i_to = endDate;
			        }
			     },
			     "autoWidth": false,
				 "columns": [
				             { "data": "DEAL" , "class": "alignCenter"},
				             { "data": "LOGIN", "class": "alignCenter" },
				             { "data": "OPEN_TIME", "class": "alignCenter" },
				             { "data": "TYPE","class": "alignRight"  },
				             { "data": "SYMBOL","class": "alignRight" },
				             { "data": "VOLUME","class": "alignRight" },
				             { "data": "CLOSE_TIME","class": "alignRight" },
				             { "data": "AGENT","class": "alignRight" },
				             { "data": "SWAP","class": "alignRight" },
				             { "data": "PROFIT","class": "alignRight" },
				             { "data": "COMMENT","class": "alignRight" }
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

			 $('#tb_account tbody').on('click', 'tr', function () {

				  // Get row ID
			      var rowId = $(this).index();
			 
			      var groupCells = $('#tb_account tr');

            	 $.each(groupCells, function( index, value ) {
            		 $(value).removeClass("active");
            	 });

			  	  // If checkbox is checked and row ID is not in list of selected row IDs
			      if(rowId != -1){
			    	  selectedBasketCode =  $(this).attr('value');
			          $(this).addClass("active");
			          $('#dataTables-example').DataTable().ajax.reload();
			      }
			   } );

			 $('#fromDate').on('change', function(){
				 $(this).datepicker('hide');
		 	});

			 $('#toDate').on('change', function(){
				 $(this).datepicker('hide');
		 	});
		}

		function onClickSearch() {
			 $('#dataTables-example').DataTable().ajax.reload();
		}
			
</script>

