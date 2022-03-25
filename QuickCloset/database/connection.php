<?php
// Connect to Database
$con=mysqli_connect("localhost", "root", "", "QuickCloset");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}
?>