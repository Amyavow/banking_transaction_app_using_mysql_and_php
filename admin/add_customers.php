<?php
	session_start();

	//include ('db_config/dbconnect.php');

	include ('../db_config/auth.php');

	authenticate();

	$admin_id = $_SESSION['administrator_id'];
	$admin_name =$_SESSION['administrator_name']

?>

<!DOCTYPE html>
<html>
<head>
	<title>Swap Space Bank</title>
</head>
<body>
	<?php
		echo "<h3> Welcome, Administrator $admin_name with ID $admin_id </h3>";


	?>
	<hr>

	<a href="admin_home.php">Home</a>
	<a href="add_customers.php">Add Customers</a>
	<a href="view_customers.php">View</a>
	<a href="logout.php">Logout</a>

	<h3>Customer Registration Form</h3>
	<p>Please fill in the details below</p>

	<?php

	if (isset($_POST['add'])) {
		$error = array();

		if (empty($_POST['firstname'])) {
			$error[] = 'Please fill in your firstname';
		}else{
			$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
		}



		if (empty($_POST['lastname'])) {
			$error[] = 'Please fill in your lastname';
		}else{
			$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		}



		if (empty($_POST['email'])) {
			$error[] = 'Please fill in your email';
		}else{
			$email = mysqli_real_escape_string($db, $_POST['email']);
		}




		if (empty($_POST['phone'])) {
			$error[] = 'Please fill in your phonenumber';
		}elseif (!is_numeric($_POST['phone'])) {
			$error[] = 'Enter Appropriate Value for Phone';
		}

		else{
			$phone = mysqli_real_escape_string($db, $_POST['phone']);
		}




		if (empty($_POST['accounttype'])) {
			$error[] = 'Please select your account type';
		}else{
			$accounttype = mysqli_real_escape_string($db, $_POST['accounttype']);
		}



		if (empty($_POST['openingbalance'])) {
			$error[] = 'Please fill in your openingbalance';
		}elseif (!is_numeric($_POST['openingbalance'])) {
			$error[] = 'Enter Appropriate Value for Opening Balance';
		}

		else{
			$openingbalance = mysqli_real_escape_string($db, $_POST['openingbalance']);
		}

		if (empty($_POST['securityquestion'])) {
			$error[] = 'Answer the security question';
		}else{
			$securityquestion = mysqli_real_escape_string($db, $_POST['securityquestion']);
		}



		if (empty($_POST['password'])) {
			$error[] = 'Enter your password';
		}else{
			$password = md5(mysqli_real_escape_string($db, $_POST['password']));
		}


		if (empty($error)) {
			$insert = mysqli_query($db, "INSERT INTO customer VALUES 
															(NULL,
															'".$firstname."',
															'".$lastname."',
															'".$email."',
															'".$phone."',
															'".$accounttype."',
															'".$openingbalance."',
															'".$openingbalance."',
															'".rand(1000000000, 9999999999)."',
															'".$securityquestion."',
															'".$password."',
															'".$admin_id."'
																			)
																			") or die(mysqli_error($db));

			$success = "Customer Successfully added";
			header("location:add_customers.php?success=$success");

		}else{
			foreach ($error as $error) {
				echo "<p> $error </p>";
			}
		}


	}
	if (isset($_GET['success'])) {
		$succ = $_GET['success'];

		echo "$succ";
	}



	  ?>



	<form action="" method="post">
		<p>Firstname: <input type="text" name="firstname"></p>
		<p>Lastname: <input type="text" name="lastname"></p>
		<p>Email: <input type="email" name="email"></p>
		<p>Phone Number: <input type="tel" name="phone" maxlength="11"></p>

		<?php
			$account = array('Savings', 'Fixed', 'Domicilliary');
			?>

		  <p>Account type: <select name="accounttype">
		  	<option value=""> Select account type</option>

		  	<?php
		  	foreach ($account as $account) {?>
		  	<option value="<?php echo $account?>"><?php echo $account?></option>
		  	<?php } ?>
		  </select></p>

		  <p>Opening Balance<input type="text" name="openingbalance"></p>
		  <p>Security Question: <b> What is your mother's maiden name? </b><input type="text" name="securityquestion"></p>
		  <p>Password<input type="text" name="password"></p>

		  <input type="submit" name="add" value="Add Customer">
		
	</form>

</body>
</html>