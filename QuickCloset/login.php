<?php
include('database/connection.php'); //Get the database conection : $con
$info="";
$err="";
$warn="";

$url= $_SERVER['REQUEST_URI'];  //get the current url
$url_components = parse_url($url); //get all url compenents
//check if url components have params named warn
if(isset($url_components['query'])){
    parse_str($url_components['query'], $params);
    $warn = $params['warn'];
}

//start the session if not started already
if(!isset($_SESSION)) { session_start(); } 

//if login button clicked
if(isset($_POST['login'])){
  $username = $_POST['username']; //get username from user
  $password = $_POST['password']; //get password from user 

  //check in users table if it has entry for that username and password
  $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
  $result = mysqli_query($con,$sql) or die( mysqli_error($con));
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);
      
  // If result matched $username and $password,  it should have exact 1 row
  //because usernames are unique
  if($count == 1) {
    //Login succesful
    $_SESSION['username'] = $username; //store username in session
	$info = "Login Sucessful."; 
	header('Location: index.php'); //redirect to home page after login
  }else {
    //login failed show error message to user  
    $err = "Username or Password is incorrect";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
    
<?php require_once('utils/header.php') ?>

    <div class="register">
    <h1 class="dark_heading">Login</h1>
        <form class="rg_form" action="#" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="text" name="password" placeholder="Password" required />   
            <button type="submit" name="login">Login</button>  
            <?php 
            //show info error or warning if any
            if($info!=""){
                echo "<span><p class=\"success\" style=\"text-align:center\">{$info}</p></span>";
            }
            if($err!=""){
                echo "<span><p class=\"error\" style=\"text-align:center\">{$err}</p></span>";
            }
            if($warn!=""){
                echo "<span><p class=\"warning\" style=\"text-align:center\">{$warn}</p></span>";
            }
            ?>
        </form>
    </div>
          

<?php require_once('utils/footer.php') ?>