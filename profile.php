<?php
	// Required files
	require_once('includes/connect.php');
	require_once('includes/functions.php');

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
?>

<?php
	if(isset($_POST['update'])) {

		$post = get_sanitized_post();

		// Get user id
		$id = $_SESSION['id'];
		// Prevent SQL Injection
		$name = $post['name'];
		$surname = $post['surname'];
		$password = $post['password'];
		$confirm_password = $post['confirm_password'];

				
		// Check if name is empty
		if(empty($name)) {
			$errors['name'] = "Field can't be empty";
		}
				
		// Check firstname for patterns
		if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
			  $errors['name'] = "Only letters and white space allowed!";
		}
				
		// Check if surname is empty
		if(empty($surname)) {
			$errors['surname'] = "Field can't be empty";
		}

		// Check surname for patterns
		if(!preg_match("/^[a-zA-Z ]*$/",$surname)) {
			$errors['surname'] = "Only letters and white space allowed!";
		}
				
		// Check if passwords match
		if(!empty($password) || !empty($confirm_password)){
			if($password != $confirm_password){
				$errors['confirm_password'] = "Passwords do not match!";
			}
			else {
				// Create a password hash
				$pass = password_hash($password, PASSWORD_BCRYPT);
							
				$qry = 	"UPDATE users ". "SET password = '$pass' ".
						"WHERE id = '$id'";
									
				if($con->query($qry)) {
					echo "Password updated successfully!<br>";
				}
				else {
					echo "Error updating record: " . mysqli_error($con);
				}
			}			
		}
					
		// Register user if no errors are provided
		if(!count($errors) > 0) {
			//Update user information
			$query = "UPDATE users ". "SET name = '$name', surname = '$surname' ".
					 "WHERE id = '$id'";

			if($con->query($query)) {
				$success = "Record updated successfully!<br>";
			} else {
				echo "Error updating record: " . mysqli_error($con);
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Update User Profile</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.flatfly.css" />
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="container-fluid">
					<div class="navbar-header">
					  <a class="navbar-brand" href="index.php"><strong>NewsPaper</strong></a>
					</div>
					<ul class="nav navbar-nav">
						<?php
						// Select the categories and limit it to 6 in order to preserve layout
						$qry = $con->query("SELECT * FROM category LIMIT 0,6");

						// The queried category names are fetched using mysql_fetch_array() and displayed as hyperlinks.
						while($row = $qry->fetch_array()) {
							echo "<li class=\"nav-item\">";
								echo "<a href=articles.php?cat=" . $row['category'] . ">" . $row['category'] . "</a>";
							echo "</li>";
						}
						
						$id = $_SESSION['id'];
										
						$qry = $con->query("SELECT * FROM users WHERE id = $id");
															
						if(!$qry) {
							die("Query Failed: " . mysql_error());
						} else {
						
							// Fetching data from the field
							$row = $qry->fetch_array();	
						}
						
						// close connections
						$con->close();
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a href="create_article.php">New article</a>
						</li>
						<li class="nav-item">
							<a href="article_panel.php">Article Panel</a>
						</li>
						<li class="nav-item">
							<?php if($user_type == 1) { ?>
							<a href="admin/admin.php">Admin Panel</a>
							<?php } ?>
						</li>
						<li class="nav-item">
							<a href="profile.php"><?php echo $username; ?> [<?php echo $type_name;  ?>]</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="AuthN/logout.php">Log Out</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	
		<div class="container">
			<div class="row">
				<div class="col-md-5  col-md-offset-3">
					<header>
						<h1>Update Profile</h1>
						<hr>
					</header>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Update Your Settings</h3>
						</div>

						<div class="panel-body">
							<form method="post">
								<div class="form-group">
									<label for="firstname">Firstname:</label>
									<input type="text" class="form-control" name="name" placeholder="Firstname" value="<?php echo $row['name']; ?>">
									<span class="form_required"><?php if(isset($errors['name'])){ echo $errors['name']; } ?></span>
								</div>
								<div class="form-group">
									<label for="surname">Surname:</label>
									<input type="text" class="form-control" name="surname" placeholder="Surname" value="<?php echo $row['surname']; ?>">
									<span class="form_required"><?php if(isset($errors['surname'])){ echo $errors['surname']; } ?></span>
								</div>
								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6">
										<div class="form-group">
											<label for="password">New Password:</label>
											<input type="password" class="form-control" name="password" placeholder="Password">
											<span class="form_required"><?php if(isset($errors['password'])){ echo $errors['password']; } ?></span>
											<span class="form_required"><?php if(isset($errors['confirm_password'])){ echo $errors['confirm_password']; } ?></span>
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6">
										<div class="form-group">
											<label for="confirm_password">Confirm New Password:</label>
											<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
										</div>
									</div>
								</div>
								<input type="submit" value="Update Profile" name="update" class="btn btn-success">
								<input type="reset" value="Reset" name="update" class="btn btn-info">
							</form>
						</div>
					</div>
					<?php if(isset($success)){ echo "<div class=\"alert alert-success\">" . $success . "</div>"; } ?>
				</div>
			</div>
		</div>

		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>