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

</body>
</html>