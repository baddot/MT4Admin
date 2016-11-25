
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<?php require_once '501_managers_basket_create.php';?>
<?php require_once '501_managers_basket_update.php';?>
<?php require_once '501_managers_basket_alloc_group.php';?>

<link
	href="<?php echo base_url(); ?>assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />

<!-- /. NAV SIDE  -->
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2><?php echo $arr_ui_string["managers_basket_group_title"]?></h2>
				<h5><?php echo $arr_ui_string["managers_basket_group_explain"]?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />

		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading panel-table-heading-custom">
						<h3 class="panel-title"><?php echo $arr_ui_string["managers_basket_group_title"]?></h3>
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
											foreach ( $arr_ui_string ["managers_basket_group_fields"] as $row ) {
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

//Array holding selected row IDs
var group_rows_selected = [];
var basket_rows_selected = [];

function loadTable() {

	var baseURL = "<?php echo base_url(); ?>";
	var urlData = baseURL+"manager/POST_MANAGERS_BASKET_VIEW";
	
	dataTable = $('#dataTables-example').dataTable({
		"processing": true,
		"lengthChange": false,
		"searching": true,
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
	        "type":"POST"
	     },
	     "autoWidth": false,
		 "columns": [
		             { "data": "BASKET_CODE" , "class": "alignCenter"},
		             { "data": "BASKET_NAME", "class": "alignCenter" },
		             { "data": "COMMENT", "class": "alignCenter" },
		             { "data": "COUNT","class": "alignCenter"  },
		             { "data": "MARKUP_ASK", "class": "alignCenter",
		            	 "render": function (data, type, row) {
		                     var ddl = '<button class="btn btn-primary" onclick="onClickAllocGroup('+row["BASKET_CODE"]+')">'+"<?php echo $arr_ui_string['managers_basket_group_btn_alloc'];?>"+"</button>";
		                     return ddl;
		                } 
		              }
		         ]
	});
}

function onLoad() {
	loadTable();
	var table = $('#dataTables-example').DataTable();
	$('#dataTables-example tbody').on('click', 'td', function () {
		if($(this).index() != 4) {
				 var rowIdx = table
			        .cell( this )
			        .index().row;
				var data = table.row( rowIdx ).data();
		        
		       window.showUpdateDialog(data);	
		}
    } );	
}

function showUpdateDialog(data) {
   	$('#lb_basket_code').text(data['BASKET_CODE']);
	$('#tv_change_name').val(data['BASKET_NAME']);
	$('#tv_change_comment').val(data['COMMENT']);

	$('#myUpdateModalHorizontal').modal('show');
	 
	var baseURL = "<?php echo base_url(); ?>";
	requestURL = baseURL + 'manager/POST_MANAGERS_BASKET_MODIFY';
	 $("#btn_modify").click(function(){
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    i_basket_code:$('#lb_basket_code').text(),
                    i_basket_nm:$('#tv_change_name').val(),
                    i_comment:$('#tv_change_comment').val(),
                    i_tp:"U"
                },
                success: function (response) {
                	if(response.result_code == <?php echo VALUE_OK;?>) {
                		$('#dataTables-example').DataTable().ajax.reload();
                	}
                	else {
                		showAlert(msgErrArray[response.result_code]);
                	}	
                	 $('#myUpdateModalHorizontal').modal('toggle');
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
                	$('#dataTables-example').DataTable().ajax.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                }
            });
	 }); 
	 
	 $("#btn_delete").click(function(){
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    i_basket_code:$('#lb_basket_code').text(),
                    i_basket_nm:$('#tv_change_name').val(),
                    i_comment:$('#tv_change_comment').val(),
                    i_tp:"D"
                },
                success: function (response) {
                	if(response.result_code == <?php echo VALUE_OK;?>) {
                		$('#dataTables-example').DataTable().ajax.reload();
                	}
                	else {
                		showAlert(msgErrArray[response.result_code]);
                	}	
                	 $('#myUpdateModalHorizontal').modal('toggle');
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
                	$('#dataTables-example').DataTable().ajax.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                }
            });
	 }); 
}

function onClickRegister() {
	var baseURL = "<?php echo base_url(); ?>";
	 $('#myCreateModalHorizontal').modal('show');
	 
	 var baseURL = "<?php echo base_url(); ?>";
		requestURL = baseURL + 'manager/POST_MANAGERS_BASKET_CREATE';
		 $("#btn_create").click(function(){
			 $.ajax({
	                url: requestURL,
	                type: "POST", // To protect sensitive data
	                data: {
	                    ajax: true,
	                    i_basket_nm:$('#tv_create_name').val(),
	                    i_comment:$('#tv_create_comment').val()
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

function onClickAllocGroup(basket_code) {
		 var baseURL = "<?php echo base_url(); ?>";
		requestURL = baseURL + 'manager/GET_LIST_GROUP_IN_BASKET';

		 $.ajax({
             url: requestURL,
             type: "GET", // To protect sensitive data
             data: {
                 ajax: true,
                 i_basket_code:basket_code
             },
             success: function (response) {

            	 $("#tb_basket tbody").empty();
            	 group_rows_selected = [];
            	 basket_rows_selected = [];
            	 var i = 0;
            	 var groupCells = $('#tb_group tr');

            	 $.each(groupCells, function( index, value ) {
            		 $(value).removeClass("active");
            		});
         			
        		 for(i = 0; i < response.length; i++) {
        			 $("#tb_basket tbody").append("<tr><td>"+response[i]['GROUP_NAME']+"</td></tr>");
        		 }    	 
            	 
             	 $('#myAllocModalHorizontal').modal('show');	
             },
             error: function (jqXHR, msg, erro) {
             	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
             }
         });


		 $('#tb_group tbody').on('click', 'tr', function () {

			  // Get row ID
		      var rowId = $(this).index();
		 
			  // Determine whether row ID is in the list of selected row IDs 
		      var index = $.inArray(rowId, group_rows_selected);

		  	  // If checkbox is checked and row ID is not in list of selected row IDs
		      if(index === -1){
		    	  group_rows_selected.push(rowId);
		          $(this).addClass("active");

		    	 // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
		      } else if (index !== -1){
		    	  group_rows_selected[index] = -1;
		    	  $(this).removeClass("active");
		      }

				
		    } );

		 $('#tb_basket tbody').on('click', 'tr', function () {
			  // Get row ID
		      var rowId = $(this).index();
		 
			  // Determine whether row ID is in the list of selected row IDs 
		      var index = $.inArray(rowId, basket_rows_selected);

		  	  // If checkbox is checked and row ID is not in list of selected row IDs
		      if(index === -1){
		    	  basket_rows_selected.push(rowId);
		          $(this).addClass("active");

		    	 // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
		      } else if (index !== -1){
		    	  basket_rows_selected[index] = -1;
		    	  $(this).removeClass("active");
		      }
		    } );

		 $('#tb_basket tbody').on('dblclick', 'tr', function () {
			 	// Get row ID
		      	var rowId = $(this).index();

		      	var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_MANAGERS_BAKET_GROUP_ALLOC';
				var group_name = $('#tb_basket tr').eq(rowId).find('td').eq(0).text();				
					
				 $.ajax({
			         url: requestURL,
			         type: "POST", // To protect sensitive data
			         data: {
			             ajax: true,
			             i_way:2,
			             i_basket_code:basket_code,
			             i_group_name:group_name,
			         },
			         success: function (response) {
			        	 var index = $.inArray(rowId, basket_rows_selected);
			        	 basket_rows_selected[index] = -1;
			        	 
			        	 $('#tb_basket tr').eq(rowId).remove();
			         },
			         error: function (jqXHR, msg, erro) {
			         	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
			         }
			     }); 
		    } );


		 $('#tb_group tbody').on('dblclick', 'tr', function () {
			 	// Get row ID
		      	var rowId = $(this).index();

		      	var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_MANAGERS_BAKET_GROUP_ALLOC';
				var group_name = $('#tb_group tr').eq(rowId).find('td').eq(0).text();				
					
				 $.ajax({
			         url: requestURL,
			         type: "POST", // To protect sensitive data
			         data: {
			             ajax: true,
			             i_way:1,
			             i_basket_code:basket_code,
			             i_group_name:group_name,
			         },
			         success: function (response) {
			        	 $('#tb_group tr').eq(rowId).removeClass("active");

			        	 var index = $.inArray(rowId, group_rows_selected);
			        	 group_rows_selected[index] = -1;
			        	 
			        	 $("#tb_basket tbody").append("<tr><td>"+group_name+"</td></tr>");
			         },
			         error: function (jqXHR, msg, erro) {
			         	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
			         }
			     });
		    } );
		    
		    
         
		 $("#btn_right").click(function(){
			 group_rows_selected.sort(function(a, b){return b-a});
			 $.each(group_rows_selected, function(index, rowId){

				 if(rowId == -1) {
					 return;
				 }
				 
				var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_MANAGERS_BAKET_GROUP_ALLOC';
				var group_name = $('#tb_group tr').eq(rowId).find('td').eq(0).text();				
					
				 $.ajax({
			         url: requestURL,
			         type: "POST", // To protect sensitive data
			         data: {
			             ajax: true,
			             i_way:1,
			             i_basket_code:basket_code,
			             i_group_name:group_name,
			         },
			         success: function (response) {
			        	 $('#tb_group tr').eq(rowId).removeClass("active");

			        	 var index = $.inArray(rowId, group_rows_selected);
			        	 group_rows_selected[index] = -1;
			        	 
			        	 $("#tb_basket tbody").append("<tr><td>"+group_name+"</td></tr>");
			         },
			         error: function (jqXHR, msg, erro) {
			         	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
			         }
			     }); 
			 });
		 }); 

		 $("#btn_left").click(function(){
			 basket_rows_selected.sort(function(a, b){return b-a});
			 $.each(basket_rows_selected, function(index, rowId){

				 if(rowId == -1) {
					 return;
				 }
				 
				var baseURL = "<?php echo base_url(); ?>";
				requestURL = baseURL + 'manager/POST_MANAGERS_BAKET_GROUP_ALLOC';
				var group_name = $('#tb_basket tr').eq(rowId).find('td').eq(0).text();				
					
				 $.ajax({
			         url: requestURL,
			         type: "POST", // To protect sensitive data
			         data: {
			             ajax: true,
			             i_way:2,
			             i_basket_code:basket_code,
			             i_group_name:group_name,
			         },
			         success: function (response) {
			        	 var index = $.inArray(rowId, basket_rows_selected);
			        	 basket_rows_selected[index] = -1;
			        	 
			        	 $('#tb_basket tr').eq(rowId).remove();
			         },
			         error: function (jqXHR, msg, erro) {
			         	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
			         }
			     }); 
			 });
		 }); 
}


</script>

