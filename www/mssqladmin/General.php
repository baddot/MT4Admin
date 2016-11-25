<?php
ini_set ( 'display_errors', 1 );
include ('common.header.php');
include ('common.topmenu.php');
include ('common.library.php');
echo "<div id='content'>";
?>
<div class="col-md-12">
	<div class="form-group">
		<label class="col-md-1 control-label" for="textinput"><font color="white">[ServerName]</font></label>
		<div class="col-md-1" >
			<select class="selectpicker" id="cb_server_name" data-width="auto">
            		<?php
														$config = new Config ();
														$servers = $config->getServerArray ();
														$server_cnt = count ( $servers );
														
														for($i = 0; $i < $server_cnt; $i ++) {
															$server = $servers [$i];
															echo '<option value="' . $server->IP . '" port="' . $server->MSSQLPort . '" user_name="' . $server->UserName . '" passwd="' . $server->Password . '">' . $server->ServerName . '</option>';
														}
														?>
             </select>
		</div>
	</div>
</div>

<div class="col-md-12 form-group">
  <label class="col-md-1 control-label" for="textinput"><font color="white">[Query]</font></label>
  <textarea class="col-md-10 form-control" rows="5" id="query" style="margin-left: 20px; margin-right: 10px;"></textarea>
</div>
<div class="row" style="text-align: right;padding-right: 10px;margin-top: 10px;">
	<button class="btn btn-default" onclick="onClickQuery()"> Query </button> 
</div>

<div id="page-inner">
 
</div>

<script>

$(function() {
	  $('#cb_server_name').on('change', function(){
	    var selected = $(this).find("option:selected").val();
	  });
	  
	});

function onClickQuery() {
	var selectedServer = $('#cb_server_name').find("option:selected");
	var ip = selectedServer.val();
	var port = selectedServer.attr("port");
	var username = selectedServer.attr("user_name");
	var password = selectedServer.attr("passwd");
	$('#page-inner').html('');

	var query = $('#query').val();
	 var requestURL = './api/exec_query.php';
		
	 $.ajax({
            url: requestURL,
            type: "POST", // To protect sensitive data
            dataType: 'json',
            data: {
                ajax: true,
                server_name: selectedServer.text(),
                server_ip:ip,
                user_name:username,
                mssql_port: port,
                password: password,
                query:query
            },
            success: function (response) {
                if(response['result_code'] == -1) {
                	showAlert("Failed");
    				return;
                }
                else if(response['result_code'] == -2) {
                	showAlert("No Data");
    				return;
                }
                
            	showAlert("Successed");	
            	var realData = response['result_data'];
            	var fields = response['result_fields'];

           	    var container = document.getElementById("page-inner");
           	    var div = document.createElement("div");
           	    div.setAttribute("id", "data-table");
           	 	container.appendChild(div);

           	    var script = "$('#data-table').datatable( {";
     				script = script + "data:"+JSON.stringify(realData)+",";
     				script = script + "fields:"+JSON.stringify(fields)+"});";
     	
                 var JS= document.createElement('script');
                 JS.text= script;
                 document.body.appendChild(JS);
            },
            error: function (jqXHR, msg, erro) {
            	showAlert("Failed");
            	location.reload();
            }
        });
}
</script>

<?php
echo "</p>";
echo "</div></div>";

echo "<div class='clear'></div>";

// closing div id='content'
echo "</div>";

include ('common.footer.php');

// closing div id=outer
echo "</div>";

echo "</body></html>";

?>
