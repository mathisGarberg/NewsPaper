<?php
	
	// Start the user session
	session_start();
	
	$db_hostname = 'localhost'; // local web server
	$db_database = 'a_database'; // Select database
	$db_username = 'root'; // Will be root by default
	$db_password = ''; // Empty with default settings

	// Connecting to our mysql database
	$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
	
	// Check connection
	if(!$con){
		die('Connection failed with mysqli API:' . mysqli_connect_error());
	}
	
?>