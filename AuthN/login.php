<?php

	// Require the connection file
	require_once('../includes/connect.php');



	// Check if login button is pressed
	if (isset($_POST['login'])) {

		$user = mysqli_real_escape_string($con, $_POST['uname']);
		$pass = $_POST['password'];

		$query = "SELECT * FROM users WHERE username='$user'";
		$result = $con->query($query); // Fetch the row where username matches

		if($result->num_rows != 0){
			$row = $result->fetch_array(MYSQL_BOTH);
			if(password_verify($pass, $row['password'])) {

				// regenerate the session id
				session_regenerate_id();
				//$_SESSION['user'] = [

				//];

				// set session parameters
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $user;
				$_SESSION['name'] = $row['name'];
				$_SESSION['surname'] = $row['surname'];

				// Redirect user to the main page
				header("Location: ../index.php");
			}
			else {
				$errors = "Wrong password!";
			}
		}
		else {
			$errors = "Wrong username or password!";
		}

	}

	// close connections
	$con->close();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8">

		<!-- Stylesheets -->
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.flatfly.css" />
	</head>
	<body>

		<!-- Navigation -->
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

			<!-- Registration Form -->
			<div class="row">

				<!-- Header -->
				<div class="col-md-5 col-md-offset-3">
				  <header>
					<h1>Sign In Form</h1>
					<hr>
				  </header>
				</div>

				<!-- Sign In Form -->
				<div class="col-xs-12 col-sm-7 col-md-5 col-sm-offset-1 col-md-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Dear user, log in to access the page</h3>
						</div>
						<div class="panel-body">
							<form method="post" name="RegisterForm">

								<!-- Username -->
									<div class="form-group">
										<input type="text" class="form-control" name="uname" placeholder="Username" value="<?php if(isset($_POST['uname'])){ echo $_POST['uname']; } ?>" >
									</div>

								<!-- Password -->
									<div class="form-group">
										<input type="password" class="form-control" name="password" placeholder="Password">
									</div>

								<div class="row">
									<div class="col-lg-5">
										<div class="checkbox">
											<label>
												<input type="checkbox"> Remember me
											</label>
										</div>
									</div>
									<div class="col-lg-7">
										<span class="pull-right">
										<input type="submit" value="Sign In" name="login" class="btn btn-info btn-block">
									</div>
								</div>
								<hr>
								<p>Dont have an account? <a href="register.php">Sign up here!</a></p>
							</form>
						</div>
					</div>
					<span id="errors"><?php if(isset($errors)) { echo $errors; } ?></span>
				</div>
			</div><!-- end row -->
		</div> <!-- end container -->

		<!-- Fixed footer -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>
