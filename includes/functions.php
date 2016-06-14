<?php
	
	
	// Verify whether the logged in user can view the content
	if(isset($_SESSION['id'])) {
		$my_id = $_SESSION['id'];
		$user_query = $con->query("SELECT username, user_type FROM users WHERE id = '$my_id'");
		$run_user = $user_query->fetch_array(MYSQLI_ASSOC);
		$username = $run_user['username'];
		$user_type = $run_user['user_type'];
		$query_type = $con->query("SELECT name FROM user_type WHERE id = '$user_type'");
		$run_level = $query_type->fetch_array(MYSQLI_ASSOC);
		$type_name = $run_level['name'];
	}
	else {
		// Redirect user to register page
		header('Location: register.php');
	}
	
?>