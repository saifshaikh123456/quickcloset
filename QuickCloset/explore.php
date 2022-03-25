<?php
include('database/connection.php'); //get the db connection : $con
//start the session if not started already
if(!isset($_SESSION)) { session_start(); }

$info=""; //this variable is used to show message to user

//if user searched something
if(isset($_POST['search'])){
	$q = $_POST['search']; //get the user input
	//this query selects all users with username matching search query 
	//and excludes the current user
	$sql = "SELECT * FROM users WHERE username LIKE '%$q%' AND username <> \"".$_SESSION['username']."\"";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="No matches were found for your search";}
}else{
	//Select all users except the current user
	$sql = "SELECT * FROM users WHERE username <> \"".$_SESSION['username']."\"";
	$results = mysqli_query($con,$sql) or die( mysqli_error($con));
	$count = mysqli_num_rows($results);
	if($count==0){$info="No more users are registered on this platform";}
}

//if follow button clicked
if(isset($_POST['follow'])){
	$username = $_SESSION['username']; //get the current users name from session
	$following = $_POST['username']; //get the name of user he wants to follow
	//insert them in the following table
	$sql="INSERT INTO `following`(`username`,`following`) VALUES('$username','$following')";
  	$result=mysqli_query($con,$sql);
}

//if following button clicked
if(isset($_POST['following'])){
	$username = $_SESSION['username']; //get the current users name from session
	$following = $_POST['username'];	//get the name of user he wants to unfollow
	//delete them from the following table
	$sql="DELETE FROM `following` WHERE username='$username' AND following='$following'";
  	$result=mysqli_query($con,$sql);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Explore</title>
    
<?php require_once('utils/header.php') ?>

<h1 class="heading_user">Explore</h1>

<form action="#" method="POST" class="search">
	<i class="fa-solid fa-search"></i>
	<input type="text" name="search" placeholder="Search..."/>
</form>

<div>
	<?php
	//if count is 0 then info variable will have some message : display it 
	if($count == 0){
		echo "<p style=\"color:black;display:grid;place-items:center;height:70vh\">".$info."</p>";
	}
	//loop through all users and display them on page
	while ($users = mysqli_fetch_array($results)) {
		//check if the current user already follows to this user or not
		//this query check if there is any entry in following table with username as current user and following as the username in loop
		//if yes then it means current user already follows this user
		$sql2 = "SELECT * FROM following WHERE username = \"".$_SESSION['username']."\" AND following = \"".$users['username']."\" ";
		$result = mysqli_query($con,$sql2) or die( mysqli_error($con));
		$count = mysqli_num_rows($result);

		echo "<div class=\"users\">";
		echo "<img src=\"./assets/user.png\" />";
		echo "<p>".($users['username'])."</p>";
		//already following
		if($count>0){
			echo "<form action=\"#\" method=\"POST\"><input type=\"hidden\" value=".$users['username']." name=\"username\" />";
			echo "<button style=\"background:green;\" name=\"following\">Following</button></form>";
		}
		//not following
		else{
			echo "<form action=\"#\" method=\"POST\"><input type=\"hidden\" value=".$users['username']." name=\"username\" />";
			echo "<button name=\"follow\">Follow</button></form>";
		}
		echo "</div>";
	}
	?>
</div>

<?php require_once('utils/footer.php') ?>