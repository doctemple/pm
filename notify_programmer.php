<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");


    /* Group Manager */
	//$sToken = "4R1OhfSz5zPMz6ApZk3zKAjVWHklrZ0JOw6SNogEBWK";

	/* Group Programmer */
	$sToken = "EToMsivNYBhVWceNN1AnxCjOftMbl00oGwdUisZaDxm";

	$sMessage = $_POST['message_textpm'];

	echo "<pre>$sMessage</pre>";


	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		header( "refresh:1; url=report.html" ); 
		echo "<h1>status : ".$result_['status']."</h1>"; 
		echo "<h2>message : ". $result_['message']."</h2>";

	} 
	curl_close( $chOne );   

?>