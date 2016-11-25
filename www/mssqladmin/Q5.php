<?php
ini_set ( 'display_errors', 1 );
include ('common.header.php');
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

for($i = 0; $i < $server_cnt; $i++) {
	$server = $servers[$i];

	$model = new Model($server->IP, $server->MSSQLPort, $server->UserName, $server->Password);
	$data = Array();
	$server_name = (string)$server->ServerName;
	$data['ServerName'] = $server_name;
	$fields = Array("ServerName");
	
	$realData = Array();
	array_push($realData, $data);
	
	echo '<div id="data-table'.$i.'"> </div>';
	$table_id = 'data-table'.$i;
			
	echo "<script>";
	echo "$('#$table_id').datatable( {";
	echo "data:".json_encode($realData).",";
	echo "fields:".json_encode($fields);
	echo "});";
	echo "</script>";

	$data1 = $model->q5_query1();
	if($data1 != false) {
		$fields1 = array_keys($data1[0]);
		echo '<div id="data-table-2-'.$i.'" class="table table-responsive"> </div>';
		echo '</div>';
	
		$table_id1 = 'data-table-2-'.$i;
	
		echo "<script>";
		echo "$('#$table_id1').datatable( {";
		echo "data:".json_encode($data1).",";
		echo "fields:".json_encode($fields1);
		echo "});";
		echo "</script>";
	}
}

?>

</div> <!-- page inner -->

<script>

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
