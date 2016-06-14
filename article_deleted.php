<?php require_once('includes/connect.php'); ?>
<?php require_once('includes/functions.php'); ?>
<html>
	<head>
		<title>NewsPaper</title>
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
						<a class="navbar-brand" href="index.php">NewsPaper</a>
					</div>
					<ul class="nav navbar-nav">
					<?php
					// select the categories and limit it to 6 in order to preserve layout
					$qry = $con->query("SELECT * FROM category LIMIT 0,6");

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
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-3">
					<div class="row">
						<div class="col-md-6">
						<?php
						if(isset($_GET['id'])) {

							$id = $_GET['id'];
							$qry = $con->query("DELETE FROM articles WHERE id = '$id'");

							if(!$qry) {
								die("Query failed: " . mysql_error());
							} else {
								echo "<div class=\"alert alert-success\">";
									echo "Article " . $id . " Deleted Successfully";
								echo "</div>";
							}
						}
						?>
						<a href="article_panel.php">Go back to Article Panel</a>
						</div>
					</div>	
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
