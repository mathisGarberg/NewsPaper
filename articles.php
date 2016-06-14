<?php require_once('includes/connect.php'); ?>
<html>
	<head>
		<title>NewsPage</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.flatfly.css" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	</head>
	<body>
		<?php 
		// verify user
		if(!isset($_SESSION['id'])) {	
		?>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="index.php"><strong>NewsPaper</strong></a>
					</div>
					<ul class="nav navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="AuthN/register.php">Register</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="AuthN/login.php">Login</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<?php
		} else {
			$my_id = $_SESSION['id'];
			$user_query = $con->query("SELECT username, user_type FROM users WHERE id = '$my_id'");
			$run_user = $user_query->fetch_array(MYSQLI_ASSOC);
			$username = $run_user['username'];
			$user_type = $run_user['user_type'];
			$query_type = $con->query("SELECT name FROM user_type WHERE id = '$user_type'");
			$run_level = $query_type->fetch_array(MYSQLI_ASSOC);
			$type_name = $run_level['name'];
		?>
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
						<?php 
						if($user_type == 1) { 
							echo "<a href=\"admin/admin.php\">Admin Panel</a>";
						}
						?>
						</li>
						<li class="nav-item">
							<a href="profile.php">
								<?php echo $username . " [" . $type_name . "]"; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="AuthN/logout.php">Log Out</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<?php
		}
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-offset-1 col-md-offset-1">
				<?php 
				// if the value is set in $_GET['id'], the table articles is
				// shown with the help of article id, recieved from index.php
				if(isset($_GET['id'])) {
					
					$id = $_GET['id'];
					
					// query database table article
					$qry = $con->query("SELECT * FROM articles WHERE id = $id");
					
					// fetch the queried row from the table article
					while ($row = $qry->fetch_array()) {
						echo "<h2>" . $row['title'] . "</h2>";
						echo "<img width=\"100%\" src=\"uploads/" . $row['image'] . "\"><br><br>";
						echo "<p>" . nl2br($row['content']) . "</p>";
						echo "<div class=\"content-box\">";
							echo "<p>" . "By: " . "<a href=\"#\">" . $row['author'] . "</a>" . "</p>";
							echo "<div class=\"article-rate\">";
								echo "<p>Rate this article: ";
								foreach(range(1,5) as $rating) {
									echo "<a href=\"rate.php?article=" . $row['id'] . "&rating=" . $rating . "\">" . $rating . "</a>";
								}
							echo "</p></div>";
							echo "<p>" . date('M j, Y', strtotime($row['ts'])) . "</p>";
						echo "</div><br>";
					}
				}
				
				// based on the category name recieved from index.php
				// the last added article is displayed
				if(isset($_GET['cat'])) {
					
					$cat = $_GET['cat'];
					
					$qry = $con->query("SELECT * FROM articles WHERE category='$cat' ORDER BY articles.id DESC");
					
					$num_rows = mysqli_num_rows($qry);
					
					if ($num_rows) {
						echo "<h2>" . $cat . "</h2>";
						echo "<hr>";
						while($row = $qry->fetch_array()) {
							echo "<div class=\"panel panel-default\">";
								echo "<div class=\"panel-body\">";
									echo "<h2><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</h2></a>" . "<br>";
									echo "<img width=\"400\" src=\"uploads/" . $row['image'] . "\">";
									echo "<p>" . substr($row['content'],0,200) . "<a href=articles.php?id=" . $row['id'] . 
									">" . " Read More..." . "</a></p>"; // Substring is used to limit the number of characters displayed
									echo "<p>" . "Author: " . $row['author'] . "</p>";
									echo "<p>" . date('M j, Y', strtotime($row['ts'])) . "</p>";
								echo "</div>";
							echo "</div>";
						}
					} else {
						echo "<h2>" . $cat . "</h2>";
						echo "<hr>";
						echo "<h3>No Articles</h3>";
					}
				}
				
				// based on the id recieved from index.php through the url,
				// the category of the particular article is determined
				
				if(isset($_GET['id'])) {
					
					$id = $_GET['id'];
					
					$qry = $con->query("SELECT category FROM articles WHERE id='$id'");
					
					// fetching data from the field "title"
					$row = $qry->fetch_array();
					$cat = $row['category'];
					
					// once the category of the article is determined
					// this section is used to display the title of all
					// the articles belonging to that category 
					
					$qry = $con->query("SELECT * FROM articles WHERE category='$cat' order by articles.id DESC");
					
					while($row = $qry->fetch_array()) {
						//echo $row['title'];
						echo "<li><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></li>";
					}
				}
				
				// based on the category name recieved from index.php file
				// title names of all the articles belong to the category
				// is displayed with hyperlinks 
				
				if(isset($_GET['cat'])) {
					
					$cat = $_GET['cat'];
					
					$qry = $con->query("SELECT * FROM articles WHERE category='$cat' order by articles.id DESC");
					
					while($row = $qry->fetch_array()) {
						echo "<li><a href=articles.php?id=".$row['id'].">".$row['title']."</a></li>";
					}
				}
				?>
				</div>
				<div class="col-md-3">
				<?php
				// selecting & querying the table "articles" in
				// descending order reffering to the field "id"
				// and limiting the number of results to 10
				$data = $con->query("SELECT * FROM articles order by articles.id DESC LIMIT 0, 10");
				
				while($row = $data->fetch_array()) {
					echo "<li><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></li>";
				}
				
				$con->close();
				
				?>
				</div>
			</div>
		</div>
		
		<div class="footer navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<p class="navbar-text">NewsPaper &copy; <?php echo date("Y"); ?> - All Rights Reserved</p>
			</div>
		</div>
	</body>
</html>