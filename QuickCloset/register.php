<?php
include('database/connection.php'); //Get the database connection : $con
$info="";
$err="";
$warn="";
//if register button was clicked
if(isset($_POST['register'])){
  //Get user input
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  //Insert a new entry in users table
  $sql="INSERT INTO `users`(`username`,`password`,`email`) VALUES('$username','$password','$email')";
  $result=mysqli_query($con,$sql); //mysqli_query returns boolean value
  if($result){
    $info="Registration Sucessful.";//show success message
  }else{ 
    $err=mysqli_error($con);
    //if duplicate entry error then username already exists in entry
    if(substr($err,0,15)=="Duplicate entry"){
        $err="";
        $warn="Username is already taken."; //show him this warning
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    
<?php require_once('utils/header.php') ?>

    <div class="register">
        <h1 class="dark_heading">Register</h1>
        <form class="rg_form" action="#" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="email" name="email" placeholder="Email" required />   
            <input type="text" name="password" placeholder="Password" required />   
            <button type="submit" name="register">Register</button>  
            <?php 
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