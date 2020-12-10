<?php
header("Access-Control-Allow-Origin: *");
include('Api.php');
include('Config.php');

if(isset($_POST['id']) && isset($_POST['aDate']) && isset($_POST['work'])){
$api_object = new API('emp');
$data = $api_object->update_single($_POST['id'],$_POST['work'],$_POST['aDate']);
echo $data;
}else{
echo "No Data POST,0";
}

?>