<?php require_once('includes/connect.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php 
	if(isset($_GET['article'], $_GET['rating'])) {
		
		$article = $_GET['article'];
		$rating = $_GET['rating'];
		
		if(in_array($rating, [1, 2, 3, 4, 5])) {
			
			$exists = $con->query("SELECT id FROM articles WHERE id = '$article'");
			
			// Check if there is one row or not
			if(count(mysqli_fetch_array($exists, MYSQLI_NUM))) {
				$con->query("INSERT INTO ratings (article, rating) VALUES ('$article', '$rating')");
				
				// Fetch average rating
				$result = $con->query("SELECT AVG(rating) AS average FROM ratings where article = '$article'");
				
				$row = $result->fetch_array();
				
				$average_id = (round($row['average'])* 100000) + ($article);
				
				$con->query("UPDATE articles SET average_id = '$average_id' WHERE id = '$article'");
				
			} else {
				echo "There was an error!";
			}
			
			
		}
		header('Location: articles.php?id=' . $article);
	}
?>