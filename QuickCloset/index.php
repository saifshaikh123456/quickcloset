<?php
include('database/connection.php');

$info="";

//Search logic
if(isset($_POST['search'])){
	$q = $_POST['search'];
	//select all products with title,description,price or owner that macthes user input
	$sql = "SELECT * FROM products WHERE title LIKE '%$q%' OR description LIKE '%$q%' OR price LIKE '%$q%' OR owner LIKE '%$q%'";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="No matches were found for your search";}
}
//if user dint search anything then show him all products
else{
	//first show all products owned by Quick CLoset
	$sql = "SELECT * FROM products WHERE owner = \"Quick Closet\"";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="products not available at the moment";}

	//then show all products by other users (NOTE:<> means not equal to)
	$sql2 = "SELECT * FROM products WHERE owner <> \"Quick Closet\"";
	$results2 = mysqli_query($con,$sql2) or die( mysqli_error($con));

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
    
<?php require_once('utils/header.php') ?>

<div class="home_top_btns">
	<a href="#our"><h3>Our Products</h3></a>
	<a href="#other"><h3>Browse Other Products</h3></a>
</div>

<form action="#" method="POST" class="search">
	<i class="fa-solid fa-search"></i>
	<input type="text" name="search" placeholder="Search..."/>
</form>

<a name="our"></a>
<div class="products">
	<?php
	if($count == 0){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">".$info."</p>";
	}
	//loop through all priducts and display them on page
	while ($products = mysqli_fetch_array($results)) {
		//wrap it all under a tag so when user clicks 
		//he gets redirected to product_details page with the product id in url parameters
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
	
<a name="other"></a>
<?php if(!isset($_POST['search'])){ echo "<h2 style=\"margin-left:20px;color:black;\">Other Products</h2>";} ?>
<div class="home_products_container">
	<?php
		//if user searches something all results will be shown by above block only 
		//so dont show this block if user searches something 
		if(!isset($_POST['search'])){ 
			while ($products = mysqli_fetch_array($results2)) {
				echo "<a href=\"product_details.php?id={$products['id']}\">";
				echo "<div class=\"home_product\">";
				echo "<img src=\" ".($products['image_path'])." \" />";
				echo "<p>".($products['title'])."</p>";
				echo "<p><i class=\"fa-solid fa-sterling-sign\"></i>&nbsp;".($products['price']);
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<i style=\"color:red\" class=\"fa-solid fa-heart\"></i>&nbsp;".($products['likes'])."</p>";
				echo "</div></a>";	
			}
		}
	?>
</div>
<br><br><br>


<?php require_once('utils/footer.php') ?>