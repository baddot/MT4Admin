<?php
include ('./../common.library.php');

$data = Array();
$data['ServerName'] = $_POST['server_name'];
$data['IP'] = $_POST['server_ip'];
$data['MSSQLPort'] = $_POST['mssql_port'];
$data['UserName'] = $_POST['user_name'];
$data['Password'] = $_POST['password'];
$data['query'] = $_POST['query'];

$model = new Model($data['IP'] , $data['MSSQLPort'], $data['UserName'], $data['Password']);
$result = $model->excute_query($data['query']);

$resultData = Array();
$resultData['result_code'] = 1;
if(is_array($result) == false) {
	$resultData['result_code'] = -1;	
}
else if(count($result) == 0) {
	$resultData['result_code'] = -2;
}
else {
	$resultData['result_fields'] = array_keys($result[0]);
}

$resultData['result_data'] = $result;

echo json_encode($resultData);
?>