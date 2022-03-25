<?php
include('database/connection.php'); //Get the database connection : $con
//start the session if not started already
if(!isset($_SESSION)) { session_start(); } 

$info=""; //used to diaplay info msg to user

//if user searched something
if(isset($_POST['search'])){
	$q = $_POST['search']; //get user input from search bar
	//get all rows from following table where username is current username 
	//and following is like user input
	$sql = "SELECT * FROM following WHERE username = \"".$_SESSION['username']."\" AND following LIKE '%$q%'";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="No matches were found for your search";}
}else{
	//get all rows from following table where username is current username
	$sql = "SELECT * FROM following WHERE username = \"".$_SESSION['username']."\"";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="You haven't followed anyone";}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Following</title>
    
<?php require_once('utils/header.php') ?>

<h1 class="heading_user">Following</h1>

<form action="#" method="POST" class="search">
	<i class="fa-solid fa-search"></i>
	<input type="text" name="search" placeholder="Search..."/>
</form>

<div>
	<?php
	if($count == 0){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">".$info."</p>";
	}
	//loop through all users and display on page
	while ($users = mysqli_fetch_array($results)) {
        echo "<a href=\"user_products.php?username={$users['following']}\">";
		echo "<div class=\"users\">";
		echo "<img src=\"./assets/user.png\" />";
		echo "<p>".($users['following'])."</p>";
		echo "<button name=\"view\">View Products</button>";
		echo "</div>";
	}
	?>
</div>

<?php require_once('utils/footer.php') ?>