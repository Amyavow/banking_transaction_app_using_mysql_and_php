<?php  
	
include ('../db_config/dbconnect.php');
function authenticate()
	{
		if (!isset($_SESSION['customerid']) && !isset($_SESSION['accountnumber'])&& !isset($_SESSION['customername']) ) {
			header('location:customer_login.php');
		}
	}

?>

