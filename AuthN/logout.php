<?php require_once('../includes/connect.php'); ?>

<?php

	// Mandatory assignment in Web Programming 2
	// ==========================================
	// Assignment: 2
	// Filename: logout.php
	// Author: Mathis Garberg
	// Date Created: 14.04.2016
	// Description: logout system
	// Version: 1.0
	// ==========================================

	// Unset all session variables
	$_SESSION = array();
	// Delete current session
	session_destroy();

?>
<!DOCYTPE html>
<html>
	<head>
		<title>Logout Page</title>
		<meta charset="utf-8">

		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.flatfly.css" />
	</head>
	<body>

		<!-- Navigation Menu -->
		<nav class="navbar navbar-default">


			<div class="container">


				<div class="container-fluid">
					<div class="navbar-header">
					  <a class="navbar-brand" href="../index.php">NewsPaper</a>
					</div>
					<ul class="nav navbar-nav">
					  <li><a href="register.php">Register</a></li>
					  <li><a href="login.php">Login</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- Container -->
		<div class="container">

			<!-- Log Out Message -->
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-md-7 col-sm-offset-1 col-md-offset-2">
					<!-- Logout message -->
					<p>You are logged out!</p>
				</div>
			</div>

		</div><!-- end container -->

		<!-- Fixed footer -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>
