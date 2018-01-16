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
  	<title>Funds Transfer</title>
  </head>
  <body>
    <h2>Funds Transfer</h2>
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
          $query = mysqli_query($db, "SELECT account_balance FROM customer WHERE account_number = '".$customer_account_number."' ") or die(mysqli_error($db)); //we could have skipped this block of code if we passed the account balance we got in customer_home.php, into SESSIONS: $_SESSIONS['account_balance'] = $result['account_balance']; and $account_balance = $_SESSIONS['account_balance']

          

          $result = mysqli_fetch_array($query);

          $sender_acc_balance = $result['account_balance'];



        ?>

        <h2>Funds Transfer Page</h2>
        <?php echo "<h3> Account Balance: " .$sender_acc_balance. "</h3>";  ?>

        <?php
          if (array_key_exists('transfer', $_POST)) {
            //we did not declare the error array, we instead used header to enter in all error results into the $_GET array to be pushed out as $_GET['msg']
            //Next line validates for the two form fileds
            if (empty($_POST['recipient_acc_number']) || empty($_POST['amount'])) {
              $msg = "Some fields are missing";
              header("location:transaction.php?msg=$msg");
            }elseif (!is_numeric($_POST['amount'])) {
              
              $msg = "Please enter the correct value for amount";
              header("location:transaction.php?msg=$msg");
            }elseif ($_POST['recipient_acc_number'] == $customer_account_number) {
              $msg = "This is an invlaid transaction";
              header("location:transaction.php?msg=$msg");
            }else{ //if the validation is successfull,Select these and get these from query
              $recipient_acc_number = mysqli_real_escape_string($db, $_POST['recipient_acc_number']);
              $transfer_amount = mysqli_real_escape_string($db, $_POST['amount']);

              //select recipient details from customer table

              $query1 = mysqli_query($db, "SELECT customer_id, firstname, lastname, account_balance FROM customer WHERE account_number = '".$recipient_acc_number."' 
                ") or die(mysqli_error($db));

              if (mysqli_num_rows($query1) == 1) {

                $recipient = mysqli_fetch_array($query1);



                $recipient_customer_id = $recipient['customer_id'];
                $recipient_name = $recipient['firstname']. $recipient['lastname'];
                $recipient_current_balance = $recipient['account_balance'];


                //the transaction 
                if ($sender_acc_balance < $transfer_amount) {
                  $msg = 'Insufficient Balance';
                  header("location:transaction.php?msg=$msg");
                }else{
                  $sender_new_balance =($sender_acc_balance - $transfer_amount);

                  $recipient_new_balance = ($transfer_amount + $recipient_current_balance);

                  //senders update below
                  $sender_update = mysqli_query($db, "UPDATE customer SET 
                                      account_balance =
                                      '".$sender_new_balance."' WHERE account_number = '".$customer_account_number."'
                                      ") or die(mysqli_error($db));

                  $recipient_update = mysqli_query($db, "UPDATE customer SET 
                    account_balance = '".$recipient_new_balance."' WHERE
                    account_number = '".$recipient_acc_number."'
                    ") or die(mysqli_error($db));

                  //insert for the sender and reciever
                  $sender_insert = mysqli_query($db, "INSERT INTO transaction VALUES(
                    NULL,
                    NOW(),
                    'debit',
                    'self',
                    '".$recipient_name."',
                    '".$transfer_amount."',
                    '".$sender_acc_balance."',
                    '".$sender_new_balance."',
                    '".$customer_id."')
                    ") or die(mysqli_error($db));

                  $recipient_insert = mysqli_query($db, "INSERT INTO transaction VALUES(
                                              NULL,
                                              NOW(),
                                              'credit',
                                              '".$customer_name."',
                                              'self',
                                              '".$transfer_amount."',
                                              '".$recipient_current_balance."',
                                              '".$recipient_new_balance."',
                                              '".$recipient_customer_id."')
                                              ") or die(mysqli_error($db));
                  $success = "Transaction Successful";
                  header("location:transaction.php?success=$success");
                  

                }
              }else{
                    $msg = 'Invalid Account Number';

                    header("location:transaction.php?msg=$msg");
                          }


            }
          }

          if (isset($_GET['msg'])) {
            echo "<p>".$_GET['msg']."</p>";
          }

          if (isset($_GET['success'])) {
            echo "<h3><em>".$_GET['success']."</em></h3>";
          }




          ?>

        <form method="post" action="">
          <p>Enter Recipient Account Number: <input type="text" name="recipient_acc_number"></p>

          <p>Enter Amount to be transferred: <input type="type" name="amount"></p>

          <input type="submit" name="transfer" value="Transfer">
        </form>
</body>
</html>