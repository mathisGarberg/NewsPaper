<?php require_once('includes/connect.php'); ?>
<?php require_once('includes/functions.php'); ?>
<html>
	<head>
		<title>Admin Panel</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.flatfly.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
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
					// select the categories and limit it to 6 in order to preserve layout
					$qry = $con->query("SELECT * FROM category LIMIT 0,6");

					// the queried category names are fetched using mysql_fetch_array() and displayed as hyperlinks.
					while($row = $qry->fetch_array()) {
						echo "<li class=\"nav-item\">";
							echo "<a href=articles.php?cat=" . $row['category'] . ">" . $row['category'] . "</a>";
						echo "</li>";
					}
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
			</div>
		</nav>

		<div class="container">
			<div class="col-md-7 col-md-offset-2">
				<h1>My Articles</h1>
				<hr>
				<?php

				$user_id = $_SESSION['id'];
				$qry = $con->query("SELECT * FROM articles WHERE user_id = '$user_id'");
				$num_rows = mysqli_num_rows($qry);
				
				if($num_rows) {
					echo "<table class=\"table table-bordered\">";
					while($row = $qry->fetch_array()) {
						echo "<tr>";
							echo "<td><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></td>";
							echo "<td><a href=edit_article.php?id=" . $row['id'] . ">Edit</a></td>";
							echo "<td><a href=article_deleted.php?id=" . $row['id'] . ">Delete</a></td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "<h3>No articles</h3>";
				}
				

				?>
			</div>
		</div>
		
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>
