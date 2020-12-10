<?php 
header("Access-Control-Allow-Origin: *");
header("content-type:text/javascript;charset=utf-8");   

$data= array(
array ( 'userid' => '1', 'nick' => 'น๊อต', 'status' => 'ON'),
array ( 'userid' => '2', 'nick' => 'วัฒน์', 'status' => 'OFF' ),
array ( 'userid' => '3', 'nick' => 'เต้', 'status' => 'ON' ),
array ( 'userid' => '4', 'nick' => 'เพชร', 'status' => 'OFF' ),
array ( 'userid' => '5', 'nick' => 'หนึ่ง', 'status' => 'ON' ),
array ( 'userid' => '6', 'nick' => 'โฟม', 'status' => 'OFF' ),
array ( 'userid' => '7', 'nick' => 'ติน', 'status' => 'OFF' ),
array ( 'userid' => '8', 'nick' => 'ฝน', 'status' => 'OFF' )
);

echo json_encode($data);
?>