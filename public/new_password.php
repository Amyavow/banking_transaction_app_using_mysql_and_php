<?php
session_start();

include('../db_config/dbconnect.php');

function auth()
{
	if (!isset($_SESSION['accountnumber']) && !isset($_SESSION['security'])) {
		header("location:customer_login.php");
	}
}

auth();
?>
<?php
$account_number = $_SESSION['accountnumber'];
$security_key= $_SESSION['security'];


?>
<!DOCTYPE html>
<html>
<head>
	<title>New Password</title>
	<meta charset="utf-8">
</head>
<body>
	<a href="customer_login.php">Log in with new password </a>
	<h2>Fill in details below</h2>
<?php

	if (array_key_exists('submit', $_POST)) {
		if (empty($_POST['password1']) || empty($_POST['password2'])) {

			$msg = "Some fields are empty";
			header("location:new_password.php?msg=$msg");
		}elseif ($_POST['password1'] !== $_POST['password2'] ) {
			$msg = "Please retype your password correctly";

			header("location:new_password.php?msg=$msg");
		}
		else{
			$password1 = md5(mysqli_real_escape_string($db, $_POST['password1']));

			$passwordupdate = mysqli_query($db, "UPDATE customer SET password = '".$password1."' WHERE account_number = '".$account_number."' ") or die(mysqli_error($db));

			$success = "Password successfully updated";

			header("location:new_password.php?success=$success");
		}
	}if (isset($_GET['msg'])) {
		echo "<p>".$_GET['msg']."</p>";
	}if (isset($_GET['success'])) {
		echo "<p>".$_GET['success']."</p>";
	}


  ?>

	<form action="" method="post">
		<p>Type in a new password:<input type="text" name="password1"></p>
		<p>Retype password:<input type="text" name="password2"></p>
		<p><input type="submit" name="submit" value="Submit"></p>
	</form>

</body>
</html>

