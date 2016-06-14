<?php
	// Connect to server
	$db_server = new mysqli('localhost', 'root', '');

	// Drop the database if already exists
	$query = 'DROP DATABASE IF EXISTS a_database';
	$db_server->query($query) or die('Query failed:' . $conn->error);

	// Create the database
	$query = 'CREATE DATABASE a_database';
	$db_server->query($query) or die('Query failed:' . $conn->error);
	
	// Select the database
	$db_server->select_db('a_database') or die('Can not select db:' . $conn->error);

	// Insert sql statements in query
	$query = file_get_contents('create.sql');

	// Perform query
	$db_server->multi_query($query);
	
	// Success message
	echo "Database and tables successfully created!";
	
	// Close the connection
	$db_server->close();

?>