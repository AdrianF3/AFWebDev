<?php
echo "this is the mlf_eventScript.php script";
// THIS PAGE IS DESIGNED FOR MATT LANE FOR THE #MENTAL RESET# EVENT
// IMPLEMENTED USING SHOPIFY WEBHOOKS TO PROCESS REGISTRATION OF CUSTOMERS
// AFTER PURCHASE

// STEP 1 - RECIEVE INPUT

// IMPORTED FROM SHOPIFY
define('SHOPIFY_APP_SECRET', 'my_shared_secret');


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


 ?>
