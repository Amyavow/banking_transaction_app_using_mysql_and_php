<?php

	session_start();
	include ('../db_config/dbconnect.php');


  ?>

  <!DOCTYPE html>
  <html>
  <head>
  	<meta charset="utf-8">
  	<title>Forgot Password| Swap Space Bank</title>
  </head>
  <body>
  	<h2>Fill in the details below</h2>

  	<?php
  	if (array_key_exists('submit', $_POST)) {
  		if (empty($_POST['accountnumber']) || empty($_POST['securityquestion'])) {
  			
  			$msg = "Fill in all  the fields";
  			header("location:forgot_password.php?msg=$msg");
  		}else{
  			$accountnumber = mysqli_real_escape_string($db, $_POST['accountnumber']);
  			$securityquestion = mysqli_real_escape_string($db, $_POST['securityquestion']);

  			$select =  mysqli_query($db, "SELECT * FROM customer WHERE security_question = '".$securityquestion."'") or die(msqli_error($db));

  			

  			if (mysqli_num_rows($select) == 1) {
  				
  				$result = mysqli_fetch_array($select);
  				$_SESSION['security'] = $result['security_question'];
  				$_SESSION['accountnumber'] = $result['account_number'];

  				header("location:new_password.php");
  			}else{
  				$msg = "Incorrect security key";
  				header("location:forgot_password.php?msg=$msg");
  			}
  		}

  			
  	}if (isset($_GET['msg'])) {
  		echo "<p>".$_GET['msg']."</p>";
  	}



  	  ?>

  	<form action="" method="post">
  		<p>Account Number: <input type="num" name="accountnumber"></p>
  		<p>Security question: 
  			<p>
  				<b>What is your mother's maiden name?</b>
  			</p>
  			<input type="text" name="securityquestion"></p>
  		<p><input type="submit" name="submit" value="Submit"></p>
  	</form>
  
  </body>
  </html>