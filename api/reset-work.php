<?php
header("Access-Control-Allow-Origin: *");
include('Api.php');
include('Config.php');

$api_object = new API('emp');
$data = $api_object->resetWork();
echo $data;

?>