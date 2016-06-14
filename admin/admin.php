<?php require_once('../includes/connect.php'); ?>
<?php require_once('../includes/functions.php'); ?>

<?php
	// Verify whether the user is a authorized administrator.
	// If the user isn't verified as admin, the url wil be
	// directed to login.php
	if($user_type != 1) {
		header('Location: ../profile.php');
	}
?>

<html>
	<head>
		<title>Admin Panel</title>
		<meta charset="utf-8">

		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.flatfly.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
	</head>
	<body>
	
		<!-- Navigation Form -->
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="container-fluid">
					<div class="navbar-header">
					  <a class="navbar-brand" href="../index.php">NewsPaper</a>
					</div>
					<ul class="nav navbar-nav">
						<?php

						//Displaying categories
						// Select the categories and limit it to 6 in order to preserve layout

						$qry = $con->query("SELECT * FROM category LIMIT 0,6");

						while($row = $qry->fetch_array()) {
							echo "<li class=\"nav-item\">";
								echo "<a href=../articles.php?cat=" . $row['category'] . ">" . $row['category'] . "</a>";
							echo "</li>";
						}

						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item">
							<a href="../create_article.php">New article</a>
						</li>
						<li class="nav-item">
							<a href="../article_panel.php">Article Panel</a>
						</li>
						<li class="nav-item">
							<?php if($user_type == 1) { ?>
							<a href="admin.php">Admin Panel</a>
							<?php } ?>
						</li>
						<li class="nav-item">
							<a href="../profile.php"><?php echo $username; ?> [<?php echo $type_name;  ?>]</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../AuthN/logout.php">Log Out</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- Container -->
		<div class="container">

			<!-- Admin Panel -->
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1">
					<h1>Admin Panel</h1>
					<!-- Administrator is welcomed in the admin page using the session[] statement -->
					<?php echo "Welcome " . $_SESSION['name'] . " " . $_SESSION['surname']; ?>
					<hr>

					<ul class="nav nav-tabs" role="tablist">
						<!-- Option to create a New Category -->
						<li class="active"><a href="admin.php" role="tab" data-toggle="tab">Article Summary</a></li>
						<!-- Option to create a New Category -->
						<li><a href="new_category.php" role="tab" data-toggle="tab">Create New Category</a></li>
						<!-- Optionm to remove a Category -->
						<li><a href="remove_category.php" role="tab" data-toggle="tab">Remove Category</a></li>
						<!-- Remove Users -->
						<li><a href="remove_users.php" role="tab" data-toggle="tab">Remove Users</a></li>
						<!-- View all articles option -->
						<li><a href="admin.php?id=viewall" role="tab" data-toggle="tab">View all Articles</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="home">

							<div class="row">
								<div class="col-md-6">
								<b>Articles by Category</b>
								<?php

								//Display names of all the avaliable categories
								$qry = $con->query("SELECT * FROM category");

								// Fetching data from the field "title"
								while($row = $qry->fetch_array()) {
									// When hyperinks is clicked, pass the
									//respective category to the url variable "cat"
									echo "<li><a href=admin.php?cat=" . $row['category'] . ">" . $row['category'] . "</a></li>";
								}
								?>
								</div>

								<div class="col-md-6">
								<?php
								// Conditional statement is used to check whether the url variable id
								// holds the value "viewall"
								if(isset($_GET['id']) == "viewall") {

									// If value is set, the table articles is queried to display
									// the names of all the avaliable articles
									$qry = $con->query("SELECT * FROM articles ORDER BY articles.id DESC");
									
									// Number of rows
									$num_rows = mysqli_num_rows($qry);
									
									echo "Total number of articles: " . $num_rows;
									echo "<table class=\"table table-bordered\">";
									// Fetching data from the field "title"
									while($row = $qry->fetch_array()) {
										echo "<tr>";
											// The title's are displayed as hyperlinks in 1st col
											echo "<td><a href=../articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></td>";
											// 2rd col shows delete option
											echo "<td><a href=../article_deleted.php?id=" . $row['id'] . ">Delete</a></td>";
										echo "</tr>";
									}
									echo "</table>";
								}
								?>

								<?php

								// Conditional statement to check whether the url variable
								// is set. The database table "articles" is queried with the particular category name
								// recieved through the url variable "cat" to display all the articles belonging to that
								// specific category
								if(isset($_GET['cat'])) {

									$cat = $_GET['cat'];
									
									$qry = $con->query("SELECT * FROM articles WHERE category = '$cat' ORDER BY articles.id DESC");
									
									// Number of rows
									$num_rows = mysqli_num_rows($qry);
									
									echo "Number of articles: " . $num_rows;
									echo "<table class=\"table table-bordered\">";
									while($row = $qry->fetch_array()) {
										echo "<tr>";
											echo "<td><a href=../articles.php?id=".$row['id'].">".$row['title']."</a></td>";
											echo "<td><a href=../article_deleted.php?id=".$row['id'].">Delete</a></td>";
										echo "</tr>";
									}
									echo "</table>";
								}
								?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- end containter -->

		<!-- Fixed footer -->
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>
