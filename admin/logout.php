<?php

session_start();

unset($_SESSION['administrator_id']);
unset($_SESSION['administrator_name']);

header("location:admin_login.php")


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