<?php
require_once('includes/connect.php');
require_once('includes/functions.php');

$errors = array();

// sanitize input
function get_sanitized_post() {
	global $con;
	$sanitizedPost = [];
	foreach ($_POST as $key => $value) {
		
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlentities($value);
		$value = mysqli_real_escape_string($con, $value);
		
		$sanitizedPost[$key] = $value;
	}
	return $sanitizedPost;
}

if(isset($_POST['submit'])) {
	
	$post = get_sanitized_post();
	
	$id = $post['id'];
	$cat = $post['category'];
	$tit = $post['title'];
	$img = $_FILES["image"]["name"];
	$cont = $post['content'];
	
	// check if values are empty
	if (!empty($_POST)) {
		foreach($_POST as $key=>$value) {
			  if(empty($value)) {
				$errors["$key"] = "Field can't be empty!";
			}
		}
	}
	
	if($img){
	$name=$_FILES['image']['name'];
	$tmp=$_FILES['image']['tmp_name'];
	$err=$_FILES['image']['error'];
	
		if($err==0) {
			move_uploaded_file($tmp, $name);
		}
		
		$qry = $con->query("UPDATE articles SET image = '$img' WHERE id = '$id'");
		
		if(!$qry) {
			die("Query Failed: " . mysql_error());
		}
	}
	
	if(!count($errors) > 0) {
		// creating a sql query for inserting new articles
		$qry = $con->query("UPDATE articles SET category = '$cat', title = '$tit', content = '$cont' WHERE id = '$id'");
		
		if(!$qry) {
			echo "fail!";
		} else {
			$success = "Article Updated Successfully";
		}			
	}
}
?>

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
			<?php 			
			// the recieved article is used to query the corresponding
			// article in the database table "articles"
			if(isset($_GET['id'])) {
				
				$id = $_GET['id'];						
				$qry = $con->query("SELECT * FROM articles WHERE id = $id");
										
				if(!$qry) {
					die("Query Failed: " . mysql_error());
				} else {
					// Fetching data from the field
					$row = $qry->fetch_array();
				}
			}
			?>					
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-md-5 col-lg-5 col-sm-offset-1 col-md-offset-3">
					<h2>Edit Article</h2>
					<div class="panel panel-default">
						<div class="panel-body">
							<form method="POST" enctype="multipart/form-data" name="post_articles">								<!-- Title -->
								<p>Article Id &nbsp;&nbsp;:
									<input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" />
								</p>
								<div class="form-group">
									<label for="tit">Title</label>
									<input type="text" class="form-control" name="title" value=<?php echo "\"" . $row['title'] . "\""; ?> />
									<span class="form_required"><?php if(isset($errors['title'])){ echo $errors['title']; } ?></span>
								</div>
								<div class="form-group">
									<p>
									Image:
									<label for="image"></label>	
									<input type="file" name="image" />
									(Upload New Image only if there is a change in the existing image)
									</p>
								</div>
								<div class="form-group">
									Category:
									<select name="category">
										<?php
										// Select all the existing categories from the database table category
										$qry = $con->query("SELECT * FROM category");
										
										// Categories are displayed in the select box using fetch_array()
										while($row_1 = $qry->fetch_array()) {
											if($row_1['category'] === $row['category']) {
												echo "<option value=" . $row['category'] . " selected=\"selected\">" . $row['category'] . "</option>";
											} else {
												echo "<option value=" . $row_1['category'] . ">" . $row_1['category'] . "</option>";
											}
										}
										?>
									</select>
								</div>
								Write article text:
								<label for="contents"></label>
								<div class="form-group">
									<textarea class="form-control" name="content" rows="8"><?php echo $row['content']; ?></textarea>
									<span class="form_required"><?php if(isset($errors['content'])){ echo $errors['content']; } ?></span>
								</div>
								<input type="submit" value="Submit Changes" name="submit" class="btn btn-success btn-block">
							</form>
						</div>
					</div>
					<?php
					if(isset($success)) {
						echo "<div class=\"alert alert-success\">" . $success . "</div>";
						echo "<a href=\"article_panel.php\">Go back to article panel!</a>";
					} 
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