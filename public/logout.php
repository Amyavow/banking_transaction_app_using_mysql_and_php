<?php

session_start();

include ('../db_config/dbconnect.php');

unset($_SESSION['customerid']);
unset($_SESSION['accountnumber']);
unset($_SESSION['customername']);


header("location:customer_login.php")


  ?>
  <!DOCTYPE html>
  <html>
  <head>
  	<title>Logout Page</title>
  </head>
  <body>
  	<a href="admin_home.php">Home</a>
	<a href="add_customers.php">Add Customers</a>
	<a href="view_customers.php">View</a>
	<a href="logout.php">Logout</a>
  
  </body>
  </html>