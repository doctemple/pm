<?php
header("Access-Control-Allow-Origin: *");
include('Api.php');
include('Config.php');

if(isset($_POST['id']) && isset($_POST['leave'])){
$api_object = new API('emp');
$data = $api_object->update_leave($_POST['id'],$_POST['leave']);
echo $data;
}else{
echo "No Data POST,0";
}

?>