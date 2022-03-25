<?php
    include('database/connection.php'); //Get the database connection : $con
    //start the session if not started already
    if(!isset($_SESSION)) { session_start(); } 

    //if session does not have username then user havent logged in
    //dont show product details if not logged in
    if(!(isset($_SESSION['username'])) && empty($_SESSION['username'])){
        //redirect him to login with a warning in url params
        header("Location:login.php?warn=please login to view product details");
    }

    //adding product id in session array called ids
    function addItem($id){
        if( isset($_SESSION['ids']) ){
            $exists = false;
            foreach($_SESSION['ids'] as $ids){
                if($ids == $id){
                    $exists = true;
                }
            }

            if(!$exists){
                $_SESSION['ids'][] .= $id;
            }
        }else{
            $_SESSION['ids'][] = $id;
        }
    }

    //check if url has any parametrs, it will have product id
    $url= $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);

    //get the product id from params and select that product from database products table
    $sql = "SELECT * FROM products WHERE id = ".$params['id'];
    $result = mysqli_query($con,$sql) or die( mysqli_error($con));
    $product = mysqli_fetch_array($result);

    //iif like button wasclicked
    if(isset($_POST['like'])){
        $username = $_SESSION['username'];
        $pid = $product['id'];
        //insert username and product id in likes table
        $insert="INSERT INTO `likes`(`username`,`product_id`) VALUES('$username','$pid')";
        mysqli_query($con,$insert);
        //update like by one in products table for this product
        $update="UPDATE products SET likes=likes+1 WHERE id='$pid' ";
        mysqli_query($con,$update);
        header("Refresh:0");
    }

    //if add to cart button gets  clicked
    if(isset($_POST['addtocart'])){
        //just to be safe checking if user id logged in
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
            addItem($product['id']); // add this to cart
        }else{
            //else redirect to login page with warning
            header("Location:login.php?warn=please login to view product details");
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $product['title'];?></title>
    
<?php require_once('utils/header.php') ?>

<div class="details">
    <img src=<?php echo $product['image_path']?> alt="Product Image">
    <div>
        <h1><?php echo $product['title'];?></h1>
        <h2 class="m20"> <?php echo "<i class=\"fa-solid fa-sterling-sign\"></i>&nbsp;".$product['price'] ?> </h2>
        <p class="m20"><?php echo $product['description'] ?></p>
        <p class="m20">By &nbsp;<?php echo $product['owner']."&nbsp;&nbsp;<i style=\"color:red\" class=\"fa-solid fa-heart\"></i>&nbsp;".$product['likes']; ?></p>
        <form action="#" method="POST">

        <input type="hidden" name="pid" value=<?php $product['id']?>>

        <button name="addtocart">
        Add to Cart <i class="fa-solid fa-cart-shopping"></i>
        </button>

        <?php
            //Check if user has already likes this product or not 
            $sql2 = "SELECT * FROM likes WHERE username=\"".$_SESSION['username']."\" AND product_id=\"".$product['id']."\"";
            $result2 = mysqli_query($con,$sql2) or die( mysqli_error($con));
            $count = mysqli_num_rows($result2);
            if($count>0){
                //if yes then show "Liked" button
                echo "<button style=\"margin-left:30px\">";
                echo "Liked <i style=\"color:red\" class=\"fa-solid fa-heart\"></i></button>";
            }else{
                //if no then show "like" button
                echo "<button style=\"margin-left:30px\"  name=\"like\" >";
                echo "Like <i class=\"fa-solid fa-heart\"></i></button>";
            }
        ?>
        <button style="margin-left:30px">
            Buy Now <i class="fa-solid fa-sterling-sign"></i>
        </button>
        </form>
        <div class="payments">
        <i class="fa-brands fa-paypal fa-3x"></i>
        <i class="fa-brands fa-amazon-pay fa-3x"></i>
        <i class="fa-brands fa-apple-pay fa-3x"></i>
        </div>
    </div>
</div>

<?php require_once('utils/footer.php') ?>