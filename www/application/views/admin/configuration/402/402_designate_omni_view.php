
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<?php require_once '402_designate_omni_save.php';?>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["configuration_designate_omni_title"]?></h2>
				<h5><?php echo $arr_ui_string["configuration_designate_omni_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["configuration_designate_omni_title"]?></h3>
					</div>
					<div class="panel-body">
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
											foreach ( $arr_ui_string ["configuration_designate_omni_fields"] as $row ) {
												echo "<th>$row</th>";
											}
										 ?>
									</tr>
									</thead>
									<tbody>
										 <?php
											foreach ( $data as $row ) {
												echo "<tr>";
												echo "<td>".$row['ACCOUNT']."</td>";
												echo "<td>".$row['ACCOUNT_NAME']."</td>";
												echo "<td>".$row['GROUP_NAME']."</td>";
												echo "</tr>";
											}
										 ?>
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

//Array holding selected row IDs
var account_rows_selected = -1;
var group_rows_selected = -1;

$('#myAllocModalHorizontal').on('hidden.bs.modal', function () {
	location.reload();
})

function onLoad() {
	$('#dataTables-example').dataTable({
		"processing": true,
		"lengthChange": false,
		"searching": false,
		"paging": false,
		"paging": false,
		"scrollY":  400,
        "scrollX": true,
		"info": true,
		"language": {
			  "info": "_START_- _END_(_TOTAL_)"
		 }
	});

	var table = $('#dataTables-example').DataTable();
	$('#dataTables-example tbody').on('click', 'td', function () {
		if($(this).index() != 4) {
				 var rowIdx = table
			        .cell( this )
			        .index().row;
				var data = table.row( rowIdx ).data();
		        
		       window.showSaveDialog(data);	
		}
    } );	
}

function showSaveDialog(data) {
	 var groupCells = $('#tb_group tr');

	 $.each(groupCells, function( index, value ) {
		 $(value).removeClass("active");
		});

	 var groupCells = $('#tb_account tr');

	 $.each(groupCells, function( index, value ) {
		 $(value).removeClass("active");
		});


	 $('#tb_group tbody').on('click', 'tr', function () {
		 var groupCells = $('#tb_group tr');

		 $.each(groupCells, function( index, value ) {
			 $(value).removeClass("active");
			});
			
			  // Get row ID
		      var rowId = $(this).index();
		      account_rows_selected = rowId;
		      $(this).addClass("active");			
	    } );


	 $('#tb_account tbody').on('click', 'tr', function () {
		 var groupCells = $('#tb_account tr');

		 $.each(groupCells, function( index, value ) {
			 $(value).removeClass("active");
			});
			
			  // Get row ID
		      var rowId = $(this).index();
		 	  group_rows_selected = rowId;
		      $(this).addClass("active");			
	    } );

	 $('#tb_result tbody').on('dblclick', 'tr', function () {
	
	      	 var baseURL = "<?php echo base_url(); ?>";
		   	 requestURL = baseURL + 'configuration/POST_OMNI_ACCOUNT_SAVE';
		   	 
		   	 var group_name = $(this).find('td').eq(0).text();
		   	 var account_name = $(this).find('td').eq(0).attr("value");
		   	 var account = group_name.split("/");
		   	 var row = $(this);
		   	 $.ajax({
		                url: requestURL,
		                type: "POST", // To protect sensitive data
		                data: {
		                    ajax: true,
		                    i_tp:"2",
		                    i_account:account[0],
		                    i_account_name:account_name,
		                    i_group_name:account[1]
		                },
		                success: function (response) {	
		                	row.remove();  	 
		                },
		                error: function (jqXHR, msg, erro) {
		                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
		                }
		       });
	    } );
		
	$('#myAllocModalHorizontal').modal('show');
}

function onClickSave() {
	 var baseURL = "<?php echo base_url(); ?>";
	 requestURL = baseURL + 'configuration/POST_OMNI_ACCOUNT_SAVE';
	 
	 var group_name = $('#tb_group tr').eq(group_rows_selected).find('td').eq(0).text();
	 var account = $('#tb_account tr').eq(account_rows_selected).find('td').eq(0).text();
	 var account_name = $('#tb_account tr').eq(account_rows_selected).find('td').eq(0).attr("value");
	 
	 $.ajax({
             url: requestURL,
             type: "POST", // To protect sensitive data
             data: {
                 ajax: true,
                 i_tp:"1",
                 i_account:account,
                 i_account_name:account_name,
                 i_group_name:group_name
             },
             success: function (response) {

            	 group_rows_selected = -1;
            	 basket_rows_selected = -1;
            	 var groupCells = $('#tb_group tr');

            	 $.each(groupCells, function( index, value ) {
            		 $(value).removeClass("active");
            		});

            	 var groupCells = $('#tb_account tr');

            	 $.each(groupCells, function( index, value ) {
            		 $(value).removeClass("active");
            		});
         		
        		$("#tb_result tbody").append("<tr><td value='"+account_name+"'>"+account+"/"+group_name+"</td></tr>");    	 
             },
             error: function (jqXHR, msg, erro) {
             	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
             }
    });
}


</script>


