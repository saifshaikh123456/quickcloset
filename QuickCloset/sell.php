<?php
include('database/connection.php'); //get the databse connection : $con
//start the session if not started already
if(!isset($_SESSION)) { session_start(); }

$info="";
$err="";
$warn="";
$newFile = "";

//if sell your product button was clicked
if(isset($_POST['sell'])){
    //if images was uploaded
    if(isset($_FILES['image'])){
        //store file in temporary variable
        $tmpFile = $_FILES['image']['tmp_name']; 
        //new file will be in the assets folder
        $newFile = './assets/'.$_FILES['image']['name'];
        //save the file in assets folder with same name as the user had
        $result = move_uploaded_file($tmpFile, $newFile);
        if ($result) {
            $info =  ' was uploaded<br />';
        } else {
             $err =  ' failed to upload<br />';
        }

        //get user input
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $owner = $_SESSION['username'];

        //store the product in products table
        $sql="INSERT INTO `products`(`title`,`description`,`price`,`owner`,`image_path`) VALUES('$title','$description','$price','$owner','$newFile')";
        $result=mysqli_query($con,$sql);
        if($result){
            $info="Your Product was added Sucessfully";
        }else{ 
            $err=mysqli_error($con);
        }
    }
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell</title>
    
<?php require_once('utils/header.php') ?>

<div class="sell">
        <h1 class="dark_heading">Upload your product</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
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
            <input type="text" name="title" placeholder="Title" required />
            <textarea style="height:100px" type="message" name="description" placeholder="Description" required ></textarea>   
			<div>
				<input class="half" type="file" name="image" placeholder="Image" required />   
				<input class="half" type="number" name="price" placeholder="Price" required />   
			</div>
            <button type="submit" name="sell">Sell Your Product</button>  
        </form>
    </div>

<?php require_once('utils/footer.php') ?>