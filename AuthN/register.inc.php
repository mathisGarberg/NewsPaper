<?php
	
	// Mandatory assignment in Web Programming 2
	// ==========================================
	// Assignment: 2
	// Filename: register.inc.php
	// Author: Mathis Garberg
	// Date Created: 14.04.2016
	// Description: registration system
	// Version: 1.0
	// ==========================================
	
	// Require the connection file
	require_once('../includes/connect.php');
	
	// Define global arrays
	$errors = array();
	
	// Sanitize your input
	function get_sanitized_post() {
		global $con;
		$sanitizedPost = [];
		foreach ($_POST as $key => $value) {
			if (!in_array($key, ['password'])) {
				$value = stripcslashes($value);
				$value = strip_tags($value);
				$value = mysqli_real_escape_string($con, $value);
			}
			$sanitizedPost[$key] = $value;
		}
		return $sanitizedPost;
	}
	
	// Check if form is submitted
	if(isset($_POST['register'])) {
	
		$post = get_sanitized_post();
	
		// Prevent SQL Injection
		$username = $post['username'];
		$confirm_password = $post['confirm_password'];
		$name = $post['name'];
		$surname = $post['surname'];
		$email = $post['email'];
		$pass = $post['password'];
		
		// Check if values are empty
		if (!empty($_POST)) {
			foreach($_POST as $key=>$value) {
			  if(empty($value)) {
				$errors["$key"] = "* Field can't be empty!";
			  }
			}
		}
		
		// Check username for patterns
        if(!preg_match("/^[a-zA-Z0-9_-]*$/",$username)) {
          $errors['username'] = "Username should only include letters, numbers and '_'";
        }
		
		// Check if passwords match
		if($_POST['password'] != $confirm_password){
			$errors['confirm_password'] = "Passwords do not match!";
		}
		
		// Check if email is valid
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "The email isn't valid!";
		}
		
		// Check firstname for patterns
        if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $errors['name'] = "Only letters and white space allowed!";
        }
		
		 // Check surname for patterns
        if(!preg_match("/^[a-zA-Z ]*$/",$surname)) {
          $errors['surname'] = "Only letters and white space allowed!";
        }
		
		// Check if username already exists
		$username_query = $con->query("SELECT * FROM users WHERE username='$username'");
		
		if(mysqli_num_rows($username_query) > 0) {
			$errors['username'] = "Username already exists!";
		}
		
		// Check if email already exists
		$email_query = $con->query("SELECT * FROM users WHERE email='$email'");
		
		if(mysqli_num_rows($email_query) > 0) {
			$errors['email'] = "Email already exists!";
		}
		
		// Create a password hash
		$pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
		
		// Register user if no errors are provided
		if(!count($errors) > 0) {
			// Creating a sql query for inserting new users
			$con->query("INSERT INTO users (username, password, name, surname, email, user_type) VALUES('$username', '$pass', '$name', '$surname', '$email', '2')");
			
			// Redirect registered users to log-in page
			header('Location: login.php');
		}
		
		// close connections
		$con->close();
		
	}
?>