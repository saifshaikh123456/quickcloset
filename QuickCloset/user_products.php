<?php
include('database/connection.php'); //Get database connection : $con
//start the session if not started already
if(!isset($_SESSION)) { session_start(); }

$url= $_SERVER['REQUEST_URI']; //get the current url
$url_components = parse_url($url); //parse url
parse_str($url_components['query'], $params); //store the url queries in params variable

//get all products from table where owner matches the params['username']
$sql = "SELECT * FROM products WHERE owner = \"".$params['username']."\"";
$results = mysqli_query($con,$sql) or die( mysqli_error($con));
$count = mysqli_num_rows($results);
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $params['username'] ?></title>
    
<?php require_once('utils/header.php') ?>

<h1 class="heading_user"><?php echo "Products By ".$params['username']  ?></h1>

<div class="products">
	<?php
	//if no products by this user then display this message
    if($count == 0){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">This user has no products up for sale</p>";
	}
	//loop through all products and diaplay them on page
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