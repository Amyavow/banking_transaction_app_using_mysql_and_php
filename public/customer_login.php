<?php 
	session_start();

	include ('../db_config/dbconnect.php');

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Swap Space Bank|Customers</title>
 </head>
 <body>
 	<h1>Welcome to Swap Space Bank</h1>
 	<p>Please enter your Account number and password</p>

 	<?php
 	if (array_key_exists('login', $_POST)) {
 		$error = array();

 		if (empty($_POST['accountnumber'])) {
 			$error[] = 'Please enter your account number';
 		}else{
 			$accountnumber = mysqli_real_escape_string($db, $_POST['accountnumber']);
 		}

 		if (empty($_POST['password'])) {
 			$error[] = 'Please enter your password';
 		}else{
 			$password = md5(mysqli_real_escape_string($db, $_POST['password']));
 		}


 		if (empty($error)) {
 			$select = mysqli_query($db, "SELECT * FROM `customer` WHERE `account_number` = '".$accountnumber."' AND `password` = '".$password."'  ") or die(mysqli_error($db));

 			//echo mysqli_num_rows($select); testing to see if it works well

 			if (mysqli_num_rows($select) == 1) {
 				$row = mysqli_fetch_array($select);
 				$_SESSION['customerid'] = $row['customer_id'];
 				$_SESSION['accountnumber'] = $row['account_number'];
 				$_SESSION['customername'] = $row['firstname']. ' '.$row['lastname'];
 				

 				header('location:customer_home.php');
 			}else{
 				$msg = 'Invalid Account Number or Password';

 				header("location:customer_login.php?msg=$msg");
 			}
 		} else{
 			foreach ($error as $error) {
 				echo "<p>$error</p>";
 			}
 		}
 	}

 	if (isset($_GET['msg'])) {
 		echo "<h3>".$_GET['msg']."</h3>";
 	}




 	  ?>



 	<form action="" method="post">
 		<p>Account Number: <input type="text" name="accountnumber"></p>
 		<p>Password: <input type="password" name="password"></p>
 		<input type="submit" name="login" value="Login">
 	</form>

 	<a href="forgot_password.php">Forgot your password?</a>
 
 </body>
 </html>