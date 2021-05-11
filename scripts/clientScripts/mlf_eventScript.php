<?php
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

//Send Raw Data to myself
// sendMessage($data);

// 4. Convert data to php variables.
$dataObj = json_decode($data, true);

$isEventPurchase = false;

$orderID = $dataObj['id'];
$orderEmail = $dataObj['email'];
$firstName = $dataObj['customer']['first_name'];
$lastName = $dataObj['customer']['last_name'];

$i = 0;
//determine how many line items
$numItems = count($dataObj['line_items']);

//while iterating over orders, if an order SKU matches the event SKU,
//send event message, else send data to me
while ($i <= $numItems) {
  if ($dataObj['line_items']['sku'] = '###') {
    //set event purchase true
    $isEventPurchase = true;
  } else {
    //send data to myself
    sendMessage($data);
  }
}


// 5.
while ($isEventPurchase = false) {
  // save data and send email to customer
  sendEventRegistration($dataObj);

  // 5_B . Open connection to db & save Data || failsafe, if db error, email info to my account.
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
  $orderDate = substr($dataObj[created_at], 0, 10);
  $sql = "INSERT INTO mlf_eventDB (fName, lName, email, orderCreationDate, shopifyOrderID)
  VALUES ($dataObj['customer']['first_name'], $dataObj['customer']['last_name'], $dataObj['email'], $orderDate, $dataObj['id'])";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    $msg =  "Error: " . $sql . "<br>" . $conn->error;
    sendMessage($msg . "<br>Object-->" . $data);
  }
  $conn->close();
  //end copy



} else {
  // email the data to me
  sendMessage($data);
}




// Custom functions
function sendMessage($msgData) {
  //MAIL
  $to = 'adrianf.webdev@gmail.com';
  $subject = 'Dev Testing 11';
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

function sendEventRegistration($obj) {
  $to = 'adrianf.webdev@gmail.com'; //while testing use my email - when deployed use customer email
  // $to = $obj['email']; //while testing use my email - when deployed use customer email
  $firstName = $obj['customer']['first_name'];
  // $lastName = $dataObj['customer']['last_name'];
  $subject = 'Dev Testing 11';
  $headers = 'From: webDevTesting@testing.com' . "\r\n" .
     'Reply-To: Matt@MattLaneFitness' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();

  $msg = "<p>" . $firstName . ", thank you – and get ready to Dismantle Your
  Doubt!</p>
  <p>
  Your event access information is at the very bottom of this message, and we’ve
  got an AMAZING event in store that’s going to be catered specifically to YOUR
  needs!</p>
  <p>
  How do we know this?</p>
  <p>Because YOU’RE about to tell us what you want to get out of this experience
  the most!</p>
  <p>
  With that in mind, please note the below link that will officially complete
  your registration for the event.</p>
  <p>
  It will take you to a page with 3 simple questions that we’ll use to build the
  event around, based on everyone's answers.</p>
  <p>
  You’ll note that one of those questions enters you into the running to be one
  of the few chosen hotseats where we’ll work with those people live
  individually during the event.</p>
  <p>
  Rest assured, whether you’re chosen or not, we’re doing all the legwork on the
  backend to make sure YOU are being taken care of, and we can't wait to get
  started.</p>
  <p>With that in mind, please proceed to the following link, and let us know
  your current number one challenge around your mindset that you’d like us to
  address.</p>
  <p>
  LINK ###</p>
  <p>We look forward to hearing from you, and we look forward to seeing you on
  DAY at TIME / TIME ZONE.</p>
  <p>
  Oh, and as promised, please see your Zoom invite info below.</p>
  <p>
  See you soon!<br>
  -Andrew and Matt</p>
  <br><br>

  <p>DISMANTLE YOUR DOUBT ONLINE ACCESS - ZOOM INFO:<br>
  Andrew Kap and Matt Lane are inviting you to a scheduled Zoom meeting.</p>

  <p>Topic: Dismantle Your Doubt<br>
  Time: June 21, 2021 01:00 PM Eastern Time (US and Canada)</p>

  <p>Join Zoom Meeting<br>
  https://us02web.zoom.us/j/xxxxxxxxxx</p>

  <p>Meeting ID: xxx xxxx xxxx<br>
  One tap mobile<br>
  +13017158592,,86398840620# US (Washington DC)<br>
  +13126266799,,86398840620# US (Chicago)</p>
  <p>
  Dial by your location<br>
        +1 301 715 8592 US (Washington DC)<br>
        +1 312 626 6799 US (Chicago)<br>
        +1 646 558 8656 US (New York)<br>
        +1 253 215 8782 US (Tacoma)<br>
        +1 346 248 7799 US (Houston)<br>
        +1 669 900 9128 US (San Jose)<br>
Meeting ID: xxx xxxx xxxx<br>
Find your local number: https://us02web.zoom.</p>
  ";


  // use wordwrap() if lines are longer than 70 characters
  $msg = wordwrap($msg,70);

  // send email
  mail($to,$subject,$msg,$headers);
}

 ?>
