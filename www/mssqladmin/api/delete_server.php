<?php
include ('./../common.library.php');

$id = $_POST['idx'];
$config = new Config();
$config->deleteServer($id);

?>