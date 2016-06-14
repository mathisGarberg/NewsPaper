<?php require_once('includes/connect.php'); ?>

<html>
	<head>
		<title>NewsPaper</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.flatfly.css" />
	</head>
	<body>
		<?php 
		// verify whether the logged in user can view the content
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
					
					// The queried category names are fetched using mysql_fetch_array() and displayed as hyperlinks.
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
					<h1>Latest News</h1>
					<hr>
					<form action="index.php?go" method="post">
						<div class="input-group">
							<input type="text" name="title" class="form-control" placeholder="Search for..." value="<?php if(isset($_POST['title'])){ echo $_POST['title']; } ?>">
							<span class="input-group-btn">
								<input type="submit" name="submit_search" value="Search" class="btn btn-info">
							</span>
						</div>
					</form>
					<?php 
					// Check if the submit button is pressed
					if(isset($_POST['submit_search'])) {
						// Check if the query string has a value of go
						if(isset($_GET['go'])) {
							
							// We need to ensure that visitors are only allowed to 
							// enter capital or lowercase letters as the first 
							// character in our field set
							if(preg_match("/^[A-Za-z]+/", $_POST['title'])){
								
								// Collect search criterias entered by the user in title array
								$title = explode(' ', $_POST['title']);
								
								// Assign the literal string containing the SQL query to a variable
								// We use our keyword SELECT to grav the columns we need from our articles table
								// Then we use WHERE, along with title to narrow our search field.
								// Using the LIKE keyword, we pass in percentage sign, which  is a wildcard
								// character that returns 0 or more characters. The LIKE keyword will find
								// any title that matches in our database table to that entered by the visitor.
								if(count($title) == 1) {
									$sql = "SELECT id, title FROM articles WHERE title LIKE '%" . $title[0] . "%'";
								} else {
									$sql = "SELECT id, title FROM articles WHERE title LIKE '%" . $title[0] . "%'" . "AND title LIKE '%" . $title[1] . "%'";
								}
								// Run the query
								$result = $con->query($sql);
								
								$num_rows = mysqli_num_rows($result);
								
								// Check if the query fetch an article or not
								if($num_rows > 0) {
									// Create while loop and loop through the result set
									while($row = $result->fetch_array()) {
										// Display values inside an unordered list
										echo "<ul>";
											echo "<li>" . "<a href=" . "articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></li>";
										echo "</ul>";
									}
								} else {
									echo "<p>No articles found for the entered search!</p>";
								}
							} else {
								echo "<p>Please enter a search query!</p>";
							}
										
						}
					}
					
					// Sort the values
					if(isset($_GET['sort'])) {
						
						$sort = $_GET['sort'];
						
						switch ($sort) {
							
							case 'date':
								
								// Sort Articles
								echo "<form  method=\"get\">";
									echo "<select name=\"sort\">";
										echo "<option value=\"date\" selected=\"selected\">Categorize by published date</option>";
										echo "<option value=\"rating\">Categorize by popularity</option>";
									echo "</select>";
									echo "&nbsp;&nbsp;&nbsp;";
								echo "<input type=\"submit\" value=\"Submit\" class=\"btn-info btn-xs btn\">";
								echo "</form>";
								
								// Query database table article
								// Queried in descending order
								// Limit number of rows to be queried to one
								// The last row of the table is queried
								$qry = $con->query("
									SELECT articles.id, articles.title, articles.image, articles.content, articles.author, articles.category, articles.ts, AVG(ratings.rating) AS rating
									FROM articles
									LEFT JOIN ratings
									ON articles.id = ratings.article
									GROUP BY articles.id DESC
									LIMIT 0, 5
								");
								
								// Display the records
								while($row = $qry->fetch_array()) {
									echo "<div class=\"panel panel-default\">";
										echo "<div class=\"panel-body\">";
											echo "<h2><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</h2></a>" . "<br>";
											echo "<a href=articles.php?id=" . $row['id'] . ">" . "<img width=\"400\" src=\"uploads/" . $row['image'] . "\">" . "</a>";
											echo "<p>" . substr($row['content'],0,200) . "<a href=articles.php?id=" . $row['id'] . 
											">" . " Read More..." . "</a></p>"; // Substring is used to limit the number of characters displayed
											echo "<p>" . "Author: " . $row['author'] . "</p>";
											echo "<div class=\"article-rating\">Average rating: " . round($row['rating']) . "/5</div><br>";
											echo "<p>" . date('M j, Y', strtotime($row['ts'])) . "</p>";
										echo "</div>";
									echo "</div>";
								}
								
								break;
								
							case 'rating':
							
								// Sort Articles
								echo "<form  method=\"get\">";
									echo "<select name=\"sort\">";
										echo "<option value=\"date\">Categorize by published date</option>";
										echo "<option value=\"rating\" selected=\"selected\">Categorize by popularity</option>";
									echo "</select>";
									echo "&nbsp;&nbsp;&nbsp;";
									echo "<input type=\"submit\" value=\"Submit\" class=\"btn-info btn-xs btn\">";
								echo "</form>";
								
								$qry = $con->query("
									SELECT articles.id, articles.title, articles.image, articles.content, articles.author, articles.category, articles.ts, AVG(ratings.rating) AS average
									FROM articles
									LEFT JOIN ratings
									ON articles.id = ratings.article
									GROUP BY articles.average_id DESC
									LIMIT 0, 5
								");
								
								// Loop through the articles
								while($row = $qry->fetch_array()) {
									echo "<div class=\"panel panel-default\">";
										echo "<div class=\"panel-body\">";
											echo "<h2><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</h2></a>" . "<br>";
											echo "<a href=articles.php?id=" . $row['id'] . ">" . "<img width=\"400\" src=\"uploads/" . $row['image'] . "\">" . "</a>";
											echo "<p>" . substr($row['content'],0,200) . "<a href=articles.php?id=" . $row['id'] . 
											">" . " Read More..." . "</a></p>"; // Substring is used to limit the number of characters displayed
											echo "<p>" . "Author: " . $row['author'] . "</p>";
											echo "<div class=\"article-rating\">Average rating: " . round($row['average']) . "/5</div><br>";
											echo "<p>" . date('M j, Y', strtotime($row['ts'])) . "</p>";
										echo "</div>";
									echo "</div>";
								}
								
								break;
						}
					} else {
						// Sort Articles
						echo "<form  method=\"get\">";
							echo "<select name=\"sort\">";
								echo "<option value=\"date\">Categorize by published date</option>";
								echo "<option value=\"rating\">Categorize by popularity</option>";
							echo "</select>";
							echo "&nbsp;&nbsp;&nbsp;";
							echo "<input type=\"submit\" value=\"Submit\" class=\"btn-info btn-xs btn\">";
						echo "</form>";
						
						$data = $con->query("
							SELECT articles.id, articles.title, articles.image, articles.content, articles.author, articles.category, articles.ts, AVG(ratings.rating) AS rating
							FROM articles
							LEFT JOIN ratings
							ON articles.id = ratings.article
							GROUP BY articles.id DESC
							LIMIT 0, 5
						");
							
						
						while ($row = $data->fetch_array()) {
							echo "<div class=\"panel panel-default\">";
								echo "<div class=\"panel-body\">";
									echo "<h2><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</h2></a>" . "<br>";
									echo "<a href=articles.php?id=" . $row['id'] . ">" . "<img width=\"400\" src=\"uploads/" . $row['image'] . "\">" . "</a>";
									echo "<p>" . substr($row['content'],0,200) . "<a href=articles.php?id=" . $row['id'] . 
									">" . " Read More..." . "</a></p>"; // Substring is used to limit the number of characters displayed
									echo "<p>" . "Author: " . $row['author'] . "</p>";
									echo "<div class=\"article-rating\">Average rating: " . round($row['rating']) . "/5</div><br>";
									echo "<p>" . date('M j, Y', strtotime($row['ts'])) . "</p>";
								echo "</div>";
							echo "</div>";
						}
					}
					?>
				</div>
				<div class="col-md-3">
				<?php
				// Selecting & querying the Table "articles" in
				// descending order reffering to the field "id"
				// and limiting the number of results to 10
				$data = $con->query("SELECT * FROM articles order by articles.id DESC LIMIT 0, 10");
				
				// Fetching data from the field "title"
				while($row = $data->fetch_array()) {
					echo "<ul>";
						echo "<li><a href=articles.php?id=" . $row['id'] . ">" . $row['title'] . "</a></li>";
					echo "</ul>";
				}
				
				$con->close();
				?>
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