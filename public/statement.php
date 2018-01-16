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
	<title></title>
</head>
<body>
	<h2>Welcome Home</h2>
	<?php
  		echo "<p> Customer Id: ". "<strong>". $customer_id. "</strong>"."</p>";
  		echo "<p> Account Number: ". "<strong>". $customer_account_number. "</strong>"."</p>";
  		echo "<p> Customer name: ". "<strong>". $customer_name. "</strong>"."</p>";
  	  ?>

  	  <hr>

  	  <a href="customer_home.php">Home</a>
  	  <a href="transaction.php">Transactions</a>
  	  <a href="statement.php">Statement</a>
  	  <a href="logout.php">Logout</a>

  	  <hr>
  	  <?php
  	  	$query = mysqli_query($db, "SELECT * FROM transaction WHERE customer_id = '".$customer_id."' ") or die(mysqli_error($db));

  	    ?>

  	    <table border="1">
  	    	<tr>
  	    		<th>Transaction Date</th>
  	    		<th>Transaction Type</th>
  	    		<th>Sender</th>
  	    		<th>Reciever</th>
  	    		<th>Transaction Amount</th>
  	    		<th>Previous Balance</th>
  	    		<th>Final Balance</th>
  	    	</tr>

  	    	<tr>
  	    		<?php
  	    			while ($result = mysqli_fetch_array($query)) {
  	    		  ?>
  	    		  <td><?php echo $result['transaction_date']; ?></td>
  	    		  <td><?php echo $result['transaction_type']; ?></td>
  	    		  <td><?php echo $result['sender']; ?></td>
  	    		  <td><?php echo $result['recipient']; ?></td>
  	    		  <td><?php echo $result['transfer_amount']; ?></td>
  	    		  <td><?php echo $result['initial_balance']; ?></td>
  	    		  <td><?php echo $result['final_balance']; ?></td>
  	    	</tr>
  	    	<?php }  ?>
  	    </table>

</body>
</html>