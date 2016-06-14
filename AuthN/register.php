<?php require_once('../includes/connect.php'); ?>
<?php require_once('register.inc.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
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

			<!-- Registration Form -->
			<div class="row">

				<!-- Header -->
				<div class="col-xs-12 col-sm-9 col-md-7 col-lg-5 col-sm-offset-1 col-md-offset-3">
				  <header>
					<h1>Registration Form</h1>
					<hr>
				  </header>

					<!-- JavaScript errors -->
					<div id="errors"></div>


					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Please fill in the form below</h3>
						</div>

						<div class="panel-body">
							<form method="post">

								<!-- Username -->
								<div class="form-group <?php if(isset($errors['username'])){ echo "has-error"; } ?>">
									<input type="text" class="form-control" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>">
									<span class="form_required"><?php if(isset($errors['username'])){ echo $errors['username']; } ?></span>
								</div>

								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6">
										<!-- Password -->
										<div class="form-group <?php if(isset($errors['password']) || isset($errors['confirm_password'])){ echo "has-error"; } ?>">
											<input type="password" class="form-control" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>">
											<span class="form_required"><?php if(isset($errors['password'])){ echo $errors['password']; } ?></span>
											<span class="form_required"><?php if(isset($errors['confirm_password'])){ echo $errors['confirm_password']; } ?></span>
										</div>
									</div>

									<div class="col-xs-6 col-sm-6 col-md-6">
										<!-- Confirm password -->
										<div class="form-group <?php if(isset($errors['password']) || isset($errors['confirm_password'])){ echo "has-error"; } ?>">
											<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="<?php if(isset($_POST['confirm_password'])){ echo $_POST['confirm_password']; } ?>">

										</div>
									</div>
								</div><!-- end row -->

								<!-- Email Address -->
								<div class="form-group <?php if(isset($errors['email'])){ echo "has-error"; } ?>">
									<input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
									<span class="form_required"><?php if(isset($errors['email'])){ echo $errors['email']; } ?></span>
								</div>

								<div class="row">
									<div class="col-xs-6 col-sm-6 col-md-6">
										<!-- Firstname -->
										<div class="form-group <?php if(isset($errors['name'])){ echo "has-error"; } ?>">
											<input type="text" class="form-control" name="name" placeholder="Firstname" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>">
											<span class="form_required"><?php if(isset($errors['name'])){ echo $errors['name']; } ?></span>
										</div>
									</div>

									<div class="col-xs-6 col-sm-6 col-md-6">
										<!-- Surname -->
										<div class="form-group <?php if(isset($errors['surname'])){ echo "has-error"; } ?>">
											<input type="text" class="form-control" name="surname" placeholder="Surname" value="<?php if(isset($_POST['surname'])){ echo $_POST['surname']; } ?>">
											<span class="form_required"><?php if(isset($errors['surname'])){ echo $errors['surname']; } ?></span>
										</div>
									</div>
								</div><!-- end row -->

								<input type="submit" value="Register User" name="register" class="btn btn-success">
								<input type="reset" value="Reset" name="reset" id="reset" class="btn btn-info">
							</form>
						</div><!-- end panel body -->
					</div><!-- end panel default -->
				</div>
			</div><!-- end row -->
			<script src="../js/register.js"></script>
		</div> <!-- end container -->

		<!-- Fixed footer -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>
