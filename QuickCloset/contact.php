<?php

//if send mail button clicked send the mail to business@quickcloset.com
if(isset($_POST['mail'])){
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	header("Location:mailto:business@quickcloset.com?subject=".$subject."&body=".$message."");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
    
<?php require_once('utils/header.php') ?>

<div class="contact">
	<h1 class="dark_heading">Contact Us</h1>
	<form action="#" method="POST">
		<input name="subject" type="text" placeholder="Subject" required>
		<textarea name="message" placeholder="Message" required></textarea>
		<button name="mail">Send mail &nbsp;&nbsp;<i class="fa-solid fa-envelope"></i></button>
	</form>
</div>

<?php require_once('utils/footer.php') ?>