<?php
echo "this is the mlf_eventScript.php script";
// THIS PAGE IS DESIGNED FOR MATT LANE FOR THE #MENTAL RESET# EVENT
// IMPLEMENTED USING SHOPIFY WEBHOOKS TO PROCESS REGISTRATION OF CUSTOMERS
// AFTER PURCHASE

// STEP 1 - RECIEVE INPUT

// IMPORTED FROM SHOPIFY
// define('SHOPIFY_APP_SECRET', 'my_shared_secret'); //Original Line
  define('SHOPIFY_APP_SECRET', 'd743d783774b907cf9836b1ea022e8c5a28af68d5c5e5877755cd457245c9d3c'); //Attempt #1




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

// 4. Open connection to db || failsafe, if db error, email info to my account.


// 5. Save data into mlfEvents table, auto updating the ID






// Other functions or code
// the message
$msg = $data;

$msg = $msg .  "--data added--";
$msg =  $msg . $verified;
$msg = $msg . "--verified added--";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("adrianf.webdev@gmail.com","Dev Testing01",$msg);





 ?>
