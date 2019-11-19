<?php

// echo 'hello'; die;
	 
		$server = 'localhost';
		$user = 'root';
		$pass = '';
		$db = 'fldg_database';
	

		

	$con = new mysqli($server, $user, $pass, $db);

	// echo "<pre>";
	// print_r($con); die('-test');
	
  	if($con->connect_error) {
		die("Connection Failed: ".$con->connect_error);
	}else{
		//echo 'Connection established';
	}
?>

