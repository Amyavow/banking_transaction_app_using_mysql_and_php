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
  	<title>Swap Space Bank| Customer Page</title>
  </head>
  <body>
  	<?php
  		echo "<p> Customer Id: ". "<strong>". $customer_id. "</strong>"."</p>";
  		echo "<p> Account Number: ". "<strong>". $customer_account_number. "</strong>"."</p>";
  		echo "<p> Customer name: ". "<strong>". $customer_name. "</strong>"."</p>";
  	  ?>

  	  <hr>

  	  <a href="customer_home.php">Home</a>
  	  <a href="transaction.php">Transactions</a>
  	  <a href="statement.php">Statement</a>
  	  <a href="change_password.php">Change your password</a>
  	  <a href="logout.php">Logout</a>

  	  <?php
  	  		$select = mysqli_query($db, "SELECT account_balance FROM customer WHERE account_number = '".$customer_account_number."'
  	  			") or die(mysqli_error($db));

  	  		$result = mysqli_fetch_array($select);

  	  		echo "<h3> Account Balance: N". number_format($result['account_balance'],2). "</h3>";

  	    ?>
  
  </body>
  </html>