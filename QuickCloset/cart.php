<?php
    include('database/connection.php'); //get the db connection : $con
	//start the session if not started already
    if(!isset($_SESSION)) { session_start(); } 

	//Cart Working : When add to cart button is clicked (on product_details page) 
	//its id gets stored in a session variable called ids : $_SESSION['ids']
	//$_SESSION['ids'] is an array having all the product ids for cart

	$length = 0; //this variable is used to store the count of $_SESSION['ids'] array

	//if remove button clicked
	if(isset($_POST['remove'])){
		//search the id in $_SESSION['ids'] array and remove if there
		//array_search() is a php built in method to search an element in an array
		if(FALSE !== ($key = array_search($_POST['id'],$_SESSION['ids'])))
		{
			//remove that id from session : means it will be removed from cart too
    		unset($_SESSION['ids'][$key]);
		}
	}

	//SELECT * FROM products WHERE id in (1,2,3) 
	//this above query will return all products data with id 1, 2 and 3
	//adding all ids stored in session in sql query
	if(!empty($_SESSION['ids'])){
		$sql = "SELECT * FROM products WHERE id in (";
		$x = 1;
		$length = count($_SESSION['ids']);
		if(isset($_SESSION['ids'])){
			if (is_array($_SESSION['ids']) || is_object($_SESSION['ids'])){
				foreach($_SESSION['ids'] as $ids){		
					if($x==$length){
						$sql.=$ids; //if its the last id then dont put comma after it
					}else{
						$sql.=$ids.",";
					}
					$x++;
				}
			}
		}
		$sql.=");"; //query completed
		//execute the query with mysqli_query and get all results $results
		$results = mysqli_query($con,$sql) or die( mysqli_error($con));

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
    
<?php require_once('utils/header.php') ?>

<h1 class="heading">Your Cart</h1>

<div class="products">
	<?php
	//if there are no ids in session then display this message in center
	if($length == 0){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">Nothing in your cart</p>";
	}
	//if there are ids in session
	if(!empty($results)){
		//loop through all results and display them on page
		while ($products = mysqli_fetch_array($results)) {
			echo "<a href=\"product_details.php?id={$products['id']}\">";
			echo "<div class=\"home_product\">";
			echo "<img src=\" ".($products['image_path'])." \" />";
			echo "<p>".($products['title'])."</p>";
			echo "<p><i class=\"fa-solid fa-sterling-sign\"></i>&nbsp;".($products['price']);
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<i style=\"color:red\" class=\"fa-solid fa-heart\"></i>&nbsp;".($products['likes'])."</p>";
			echo "<form action=\"#\" method=\"POST\"><input type=\"hidden\" name=\"id\" value=".$products['id']." />";
			echo "<button name=\"remove\"><i class=\"fa-solid fa-circle-minus\"></i></button></form>";
			echo "</div></a>";
		}
	}
	?>
</div>

<?php require_once('utils/footer.php') ?>