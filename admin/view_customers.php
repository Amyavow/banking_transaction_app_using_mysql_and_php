<?php
	session_start();

	//include ('db_config/dbconnect.php');

	include ('../db_config/auth.php');

	authenticate();

	$admin_id = $_SESSION['administrator_id'];
	$admin_name =$_SESSION['administrator_name'];

	$select = mysqli_query($db, "SELECT `firstname`, `lastname`, `email`, `phone_number`, `account_type`, `opening_balance`, `account_balance`, `account_number` FROM `customer`");

?>

<!DOCTYPE html>
<html>
<head>
	<title>View Customer</title>
</head>
<body>

	<a href="admin_home.php">Home</a>
	<a href="add_customers.php">Add Customers</a>
	<a href="view_customers.php">View</a>
	<a href="logout.php">Logout</a>

	<table border="1">

	<tr>
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Email</th>
		<th>Phone number</th>
		<th>Account Type</th>
		<th>Opening Balance</th>
		<th>Account Balance</th>
		<th>Account Number</th>
	</tr>

	<tr>
		<?php
		while ($result = mysqli_fetch_array($select)) {

		  ?>

		  <td><?php echo $result['firstname']?></td>
		  <td><?php echo $result['lastname']?></td>
		  <td><?php echo $result['email']?></td>
		  <td><?php echo $result['phone_number']?></td>
		  <td><?php echo $result['account_type']?></td>
		  <td><?php echo $result['opening_balance']?></td>
		  <td><?php echo $result['account_balance']?></td>
		  <td><?php echo $result['account_number']?></td>
	
	</tr>

	<?php } ?>

	</table>

</body>
</html>