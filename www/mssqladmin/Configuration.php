<?php
ini_set ( 'display_errors', 1 );
include ('common.header.php');

require_once 'Configuration_add_dlg.php';
require_once 'Configuration_modify_delete_dlg.php';
include ('common.topmenu.php');
include ('common.library.php');
echo "<div id='content'>";
?>


<?php
$config = new Config();
$servers = $config->getServerArray();
$server_cnt = count($servers); 

echo '<div  class="table-title"> <h3> Server List </h3> </div>';
echo '<div id="page-inner">';
echo '<table id="data-table" class="table-fill"> <thead> <tr > <th >ServerName</th> <th>IP</th> <th>MSSQL PORT</th> <th>MSSQL UserName</th> <th>MSSQL PWD</th> </tr> </thead>';
echo '<tbody  class="table-hover">';

for($i = 0; $i < $server_cnt; $i++) {
	echo '<tr val="'.$i.'">';
	$server = $servers[$i];
	
	echo '<td>'.$server->ServerName.'</td>';
	echo '<td>'.$server->IP.'</td>';
	echo '<td>'.$server->MSSQLPort.'</td>';
	echo '<td>'.$server->UserName.'</td>';
	echo '<td>'.$server->Password.'</td>';
	echo '</tr>';
}

echo '</tbody> </table>';
?>

<!--End Advanced Tables -->
<div class="row" style="text-align: right;padding-right: 10px;margin-top: 10px;">
	<button class="btn btn-default" onclick="onClickRegister()"> Add </button> 
</div>
</div> <!-- page inner -->
<script>

 $("#btn_create").click(function(){
	 var param = [];
	 param['ServerName'] = $('#tv_create_server_name').val();
	 param['IP'] = $('#tv_create_server_ip').val();
	 param['MSSQLPort'] = $('#tv_create_mysql_port').val();
	 param['UserName'] = $('#tv_create_mysql_username').val();
	 param['Password'] = $('#tv_create_mysql_pwd').val();

	 var requestURL = './api/add_server.php';
	
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    server_name: param['ServerName'],
                    server_ip: param['IP'],
                    user_name: param['UserName'],
                    mssql_port: param['MSSQLPort'],
                    password: param['Password']
                },
                success: function (response) {
                	showAlert("Successed to add a server.");	
                	location.reload();
                	$('#myCreateModalHorizontal').modal('toggle');
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("Failed to add a server.");
                	location.reload();
                	$('#myCreateModalHorizontal').modal('toggle');
                }
            });
 });

 $("#btn_modify").click(function(){
	 var idx = $('#myUpdateModalHorizontal').attr('val');
	 var param = [];
	 param['ServerName'] = $('#tv_modify_server_name').val();
	 param['IP'] = $('#tv_modify_server_ip').val();
	 param['MSSQLPort'] = $('#tv_modify_mysql_port').val();
	 param['UserName'] = $('#tv_modify_mysql_username').val();
	 param['Password'] = $('#tv_modify_mysql_pwd').val();

	 var requestURL = './api/modify_server.php';
	
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    idx:idx,
                    server_name: param['ServerName'],
                    server_ip: param['IP'],
                    user_name: param['UserName'],
                    mssql_port: param['MSSQLPort'],
                    password: param['Password']
                },
                success: function (response) {
                	showAlert("Successed to modify a server.");	
                	location.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("Failed to modify a server.");
                	location.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                }
            });
});

 $("#btn_delete").click(function(){
	 var idx = $('#myUpdateModalHorizontal').attr('val');
	 
	 var requestURL = './api/delete_server.php';
	
		 $.ajax({
                url: requestURL,
                type: "POST", // To protect sensitive data
                data: {
                    ajax: true,
                    idx:idx
                },
                success: function (response) {
                	showAlert("Successed to delete a server.");	
                	location.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                },
                error: function (jqXHR, msg, erro) {
                	showAlert("Failed to delete a server.");
                	location.reload();
                	$('#myUpdateModalHorizontal').modal('toggle');
                }
            });
 });

 $('#data-table tbody').on('click', 'tr', function () {

	 var $tds = $(this).find('td');
     var server_name = $tds.eq(0).text();
     var server_io = $tds.eq(1).text();
     var mssql_port = $tds.eq(2).text();
	 var mssql_username = $tds.eq(3).text();
	 var mssql_pwd = $tds.eq(4).text();
	 var idx = $(this).attr('val');
	 
	 $('#tv_modify_server_name').val(server_name);
	 $('#tv_modify_server_ip').val(server_io);
	 $('#tv_modify_mysql_port').val(mssql_port);
	 $('#tv_modify_mysql_username').val(mssql_username);
	 $('#tv_modify_mysql_pwd').val(mssql_pwd);	
	 $('#myUpdateModalHorizontal').attr('val', idx);
	 $('#myUpdateModalHorizontal').modal('show');
 } );	
 
function onClickRegister() {
	$('#tv_create_server_name').val('');
	$('#tv_create_server_ip').val('');
	$('#tv_create_mysql_port').val('');
	$('#tv_create_mysql_username').val('');
	$('#tv_create_mysql_pwd').val('');	
	$('#myCreateModalHorizontal').modal('show');
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
