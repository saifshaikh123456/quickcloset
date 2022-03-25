<?php
include('database/connection.php'); //Get database connection : $con
//start the sesison if not started already
if(!isset($_SESSION)) { session_start(); }
//select all products where owner is the current user
$sql = "SELECT * FROM products WHERE owner = \"".$_SESSION['username']."\"";
$results = mysqli_query($con,$sql) or die( mysqli_error($con));
$count = mysqli_num_rows($results);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Your Products</title>
    
<?php require_once('utils/header.php') ?>

<h1 class="heading">Your Products</h1>
<div>
	<?php
	//current user does not have any products, display this message
	if($count<1){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">You have not added any product</p>";
	}
	//loop through all products and display them on page
	while ($products = mysqli_fetch_array($results)) {
		echo "<a href=\"product_details.php?id={$products['id']}\">";
		echo "<div class=\"home_product\">";
		echo "<img src=\" ".($products['image_path'])." \" />";
		echo "<p>".($products['title'])."</p>";
		echo "<p><i class=\"fa-solid fa-sterling-sign\"></i>&nbsp;".($products['price']);
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<i style=\"color:red\" class=\"fa-solid fa-heart\"></i>&nbsp;".($products['likes'])."</p>";
		echo "</div></a>";
	}
	?>
</div>

<?php require_once('utils/footer.php') ?>