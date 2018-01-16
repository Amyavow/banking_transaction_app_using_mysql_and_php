<?php
	session_start();

	include('../db_config/dbconnect.php');

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Swap Space: Admin Login</title>
</head>
<body>

	<h1>Swap Space Bank</h1>
	<h3>Please enter your Admin Name and Password</h3>

	<?php
		if (array_key_exists('adminlogin', $_POST)) {
			$error = array();

			if (empty($_POST['adminname'])) {
				$error[] = 'Please enter your Admin Name';
			}else{
				$adminname = mysqli_real_escape_string($db, $_POST['adminname']);
			}

			if (empty($_POST['password'])) {
				$error[] = 'Enter in your password';
			}else{
				$password = md5(mysqli_real_escape_string($db, $_POST['password']));
			}

			if (empty($error)) {
				$select = mysqli_query($db, "SELECT * FROM admin WHERE admin_name = '".$adminname."' AND secured_password = '".$password."'  ") or die(mysqli_error($db));


				//echo mysqli_num_rows($select);

				if (mysqli_num_rows($select) == 1) {
					$row = mysqli_fetch_array($select);

					//BELOW, WE ESTABLISH SESSION FOR THE ADMIN
					$_SESSION['administrator_id'] = $row['admin_id'];
					$_SESSION['administrator_name'] = $row['admin_name'];
					header('location:admin_home.php'); //LOGIN IN THE USER
				}else{
					$msg = 'Invalid admin or password. Try again';

					header("location:admin_login.php?msg=$msg");
				}
			}else{
				foreach ($error as $error) {
					echo "<p>$error</p>";
				}
			}
		}


		if (isset($_GET['msg'])) {
			$error_msg = $_GET['msg'];
			echo "<p> $error_msg</p>";
		}

	?>

	<form action="" method="post">
		<p>Admin Name: <input type="text" name="adminname"></p>
		<p>Password: <input type="password" name="password"></p>

		<input type="submit" name="adminlogin" value="login">
	</form>

</body>
</html>