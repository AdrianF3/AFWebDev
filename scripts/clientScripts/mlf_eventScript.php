<?php
// echo "this is the mlf_eventScript.php script";
// THIS PAGE IS DESIGNED FOR MATT LANE FOR THE #MENTAL RESET# EVENT
// IMPLEMENTED USING SHOPIFY WEBHOOKS TO PROCESS REGISTRATION OF CUSTOMERS
// AFTER PURCHASE

// STEP 1 - RECIEVE INPUT

// IMPORTED FROM SHOPIFY
// define('SHOPIFY_APP_SECRET', 'my_shared_secret'); //Original Line
define('SHOPIFY_APP_SECRET', 'd743d783774b907cf9836b1ea022e8c5a28af68d5c5e5877755cd457245c9d3c');

// 2. VALIDATE INPUT PER HMAC (OR WHATEVER SHOPIFY POLICY)
function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];

// 3. STORE DATA INTO A PHP VARIABLE
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);
error_log('Webhook verified: '.var_export($verified, true)); //check error.log to see the result
//END SHOPIFY IMPORT
sendMessage($data);

// 4. Convert data to php variables.
$dataObj = json_decode($data, true);

$orderID = $dataObj['id'];
$orderEmail = $dataObj['email'];
$firstName = $dataObj['customer']['first_name'];
$lastName = $dataObj['customer=>last_name'];
$testString = "Test message. The order id is: " . $orderID .
 " and the email is: " . $orderEmail . "... the full name: " .
 $firstName . " " . $lastName;
sendMessage($testString);



// 5 . Open connection to db & save Data || failsafe, if db error, email info to my account.
//begin copy
$servername = "localhost";
$username = "u480905865_af_dev";
$password = "#8lN|P7Xz";
$dbname = "u480905865_client_DevDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//$sql = "INSERT INTO mlf_eventDB (fName, lName, email, orderCreationDate, shopifyOrderID)
//VALUES ()";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  $msg =  "Error: " . $sql . "<br>" . $conn->error;
  //sendMessage($msg);
}
$conn->close();
//end copy


// Custom functions
function sendMessage($msgData) {
  //MAIL
  $to = 'adrianf.webdev@gmail.com';
  $subject = 'Dev Testing 10';
  $headers = 'From: webDevTesting@testing.com' . "\r\n" .
     'Reply-To: Matt@MattLaneFitness' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();
  // the message
  $msg = $msgData;

  // use wordwrap() if lines are longer than 70 characters
  $msg = wordwrap($msg,70);

  // send email
  mail($to,$subject,$msg,$headers);
}









 ?>
