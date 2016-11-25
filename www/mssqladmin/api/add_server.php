<?php
include ('./../common.library.php');

$data = Array();
$data['ServerName'] = $_POST['server_name'];
$data['IP'] = $_POST['server_ip'];
$data['MSSQLPort'] = $_POST['mssql_port'];
$data['UserName'] = $_POST['user_name'];
$data['Password'] = $_POST['password'];

$config = new Config();
$config->addServer($data);

?>