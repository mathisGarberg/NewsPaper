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

if(isset($_POST['upload'])) {
		
	$name = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
	$err = $_FILES['image']['error'];
	$uploads_dir = __DIR__ . '/uploads';
					
	if($err === 0) {
		move_uploaded_file($tmp, "$uploads_dir/$name");
	}
					
	$post = get_sanitized_post();
					
	$id = $_SESSION['id'];
	$tit = $post['title'];
	$aut = $post['author'];
	$img = $_FILES["image"]["name"];
	$cat = $post['category'];
	$cont =  $post['content'];
					
	// check if values are empty
	if (!empty($_POST)) {
		foreach($_POST as $key=>$value) {
			  if(empty($value)) {
				$errors["$key"] = "Field can't be empty!";
			}
		}
	}
					
	if(!count($errors) > 0) {
		$qry = $con->query("INSERT INTO articles (user_id, title, image, content, author, category) VALUES ('$id', '$tit', '$img', '$cont', '$aut', '$cat')");
					
		if(!$qry) {
			echo "fail!";
		} else {
			$success = "Article added successfully!<br>";
		}
						
	}
}
?>

<html>
	<head>
		<title>NewsPage</title>
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
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-md-5 col-lg-5 col-sm-offset-1 col-md-offset-3">
					<h2>Article Generator</h2>
					<div class="panel panel-default">
						<div class="panel-body">
							<form method="POST" enctype="multipart/form-data" name="post_articles">
								<div class="form-group">
									<label for="title">Title:</label>
									<input type="text" class="form-control" name="title" value="<?php if(isset($_POST['title'])){ echo $_POST['title']; } ?>"/>
									<span class="form_required"><?php if(isset($errors['title'])){ echo $errors['title']; } ?></span>
								</div>
								<div class="form-group">
									<label for="author">Author:</label>
									<input type="text" class="form-control" name="author" value="<?php if(isset($_POST['author'])){ echo $_POST['author']; } ?>"/>
									<span class="form_required"><?php if(isset($errors['author'])){ echo $errors['author']; } ?></span>
								</div>
								<div class="form-group">
									<label for="image">Upload Image:</label>	
									<input type="file" name="image" />
								</div>
								<div class="form-group">
									<label for="category">Select a Category: </label>
									<select name="category">
									<?php 
									$qry = $con->query("SELECT * FROM category");
									
									while($row = $qry->fetch_array()) {
										echo "<option value=" . $row['category'] . ">" . $row['category'] . "</option>";
									}
									?>
									</select>
								</div>
								<label for="contents">Write article text:</label>
								<div class="form-group">
									<textarea class="form-control" name="content" rows="8"><?php if(isset($_POST['content'])){ echo $_POST['content']; } ?></textarea>
									<span class="form_required"><?php if(isset($errors['content'])){ echo $errors['content']; } ?></span>
								</div>
								<input type="submit" value="Generate Article" name="upload" class="btn btn-success btn-block">
							</form>
						</div>
					</div>
					<?php 
					if(isset($success)) {
						echo "<div class=\"alert alert-success\">" . $success . "</div>";
						echo "<a href=\"index.php\">Go back to main page!</a>";
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