<?php 
	session_start();

	include ('authcustomer.php');

  authenticate();
	$customer_id = $_SESSION['customerid'];
 	$customer_account_number = $_SESSION['accountnumber'];
 	$customer_name= $_SESSION['customername'];

 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<title>Change Password</title>
 	<style type="text/css">
 	.btn a {
	text-decoration-line: none;
	}


 	.btn a:hover {
	background-color: white;
	color: #FFA500;
	font-size:20px;
	text-decoration-line: underline;
	}
 	</style>
 </head>
 <body>

 	<?php
  		echo "<p> Customer Id: ". "<strong>". $customer_id. "</strong>"."</p>";
  		echo "<p> Account Number: ". "<strong>". $customer_account_number. "</strong>"."</p>";
  		echo "<p> Customer name: ". "<strong>". $customer_name. "</strong>"."</p>";
  	  ?>

  	  <hr>
 	<a href="customer_login.php">Log in With new password</a>
 	
 	<button class="btn" style="margin-left: 900px"><a href="customer_home.php">Back Home</a></button>
 	<h2>Please fill the form below</h2>

 	<?php

 		if (array_key_exists('changepassword', $_POST)) {
 			if (empty($_POST['oldpassword']) || empty($_POST['newpassword'])) {
 				$msg = 'One field is empty';

 				header("location:change_password.php?msg=$msg");
 			}elseif ($_POST['oldpassword'] == $_POST['newpassword']) {
 				$msg = "Your old password and new password are the same";

 				header("location:change_password.php?msg=$msg");
 			}
 			else{
 				$oldpassword = md5(mysqli_real_escape_string($db, $_POST['oldpassword']));
 				$newpassword = md5(mysqli_real_escape_string($db, $_POST['newpassword']));


 				$select = mysqli_query($db, "SELECT `password` FROM `customer` WHERE `password` = '".$oldpassword."' AND `account_number` = '".$customer_account_number."' ") or die(mysqli_error($db));

 				//echo mysqli_num_rows($select);

 				if (mysqli_num_rows($select) == 1) {
 					$result = mysqli_fetch_array($select);

 					$password = $result['password'];

 					$passwordupdate = mysqli_query($db, "UPDATE `customer` SET `password` = '".$newpassword."' WHERE account_number = '".$customer_account_number."'
 																											")
 																or die(mysqli_error($db));

 					$success = "Password successfully changed. Log in with new password";
 					header("location:change_password.php?success=$success");

 				}else{
 					$msg = 'incorrect password';
 					header("location:change_password.php?msg=$msg");
 				}
 			}
 		}
 		if (isset($_GET['msg'])) {
 			echo "<h2>". $_GET['msg']."</p>";
 		}
 		if (isset($_GET['success'])) {
 			echo "<h2><em><strong>".$_GET['success']."</strong></em></h2>";
 		}


 	  ?>
 	<form action="" method="post">
 		<p>Old password: <input type="text" name="oldpassword"></p>
 		<p>New password: <input type="text" name="newpassword"></p>
 		<p><input type="submit" name="changepassword" value="Change password"></p>
 	</form>
 
 </body>
 </html>