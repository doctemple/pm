<?php
header("Access-Control-Allow-Origin: *");
header("content-type:application/json");
include('Api.php');
//$start = microtime(true);
include('Config.php');


$api_object = new API('emp');

if(isset($_GET)){

if(@!$_GET){  

	$action = ""; 

?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>
<body>
<div class="container-fluid">
สวัสดี ชาวโลก
  </div>
</body>
</html>

<?php
	
	}else{ 

		$action = $_GET['action']; 

if($action == 'fetch_all')
{
	$data = $api_object->fetch_all();
}

if($action == 'insert')
{
	$data = $api_object->insert();
}

if($action == 'fetch_single')
{
	$data = $api_object->fetch_single($_GET["id"]);
}

if($action == 'update')
{
	$data = $api_object->update();
}

if($action == 'delete')
{
	$data = $api_object->delete($_GET["id"]);
}


if($action == 'update_single')
{
	$data = $api_object->update_single($_POST['id'],$_POST['aDate']);
	echo $data;
}else{

	echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


}

}

//print (microtime(true) - $start);
?>