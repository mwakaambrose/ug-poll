<?php
$sessionId = $_POST['sessionId'];
// Check to see whether this call is active
$isActive  = $_POST['isActive'];
// For this example, we will assume that you persist the call state in 
// a database table, or in the current session. This function will
// retrieve that. For this example, the state goes from:
// None => PromptSent => Done
//$currentCallState = getCallState($sessionId); // Implement this locally!
$currentCallState = 'None';
if ($isActive == 1)  {
  // The call is active
  
  if ($currentCallState == 'None') {
    
    // This is the First request we are receiving. Prompt for the account number
    // Compose the response
     $text = "Thank you for calling Buuza Agripoll. Press 0 followed by the hash sign to take  Survey and get Airtime Reward, press 1 followed by the hash sign to make an inquiry.press  2 followed by the hash sign to hear this message again.";
    $response  = '<?xml version="1.0" encoding="UTF-8"?>';
    $response .= '<Response >';
    $response .= '<GetDigits timeout="15" callbackUrl="http://1ae3f992.ngrok.io/ug-poll/app/includes/Menu.php" finishOnKey="#">';
    $response .= '<Say voice="man">'.$text.'</Say>';
    $response .= '</GetDigits>';
    $response .= '</Response>';
    
    // Be sure to change the call state
    $currentCallState = 'PromptSent';
    
  } else if ($currentCallState == 'PromptSent' ){
    
    // This is the second request from Africa's Talking
    $balanceArr = array(
      '1234' => 100,
      '1235' => 150,
      '1236' => 190,
      );
    // Read the dtmf digits
    $accountNumber = $_POST['dtmfDigits'];
    
    // Read the account information from the database if necessary
    if ( array_key_exists($accountNumber, $balanceArr) ) {
      $balance = $balanceArr[$accountNumber];
      $text    = "Your balance is " . $balance . " shillings. Good bye.";
    } else {
      $text = "Sorry, we could not find that account number. Good bye";
    }
    
    // Compose the response
    $response  = '<?xml version="1.0" encoding="UTF-8"?>';
    $response .= '<Response>';
    $response .= '<Say>'.$text.'</Say>';
    $response .= '</Response>';
    
    // Be sure to change the call state
    $currentCallState = 'Done';
    
  }
  
  // Ensure you save the call state. This could be a database call or a write to 
  // session storage
  //saveCurrentCallState($sessionId, $currentCallState); // Implement this locally!
  
  // Print the response onto the page so that our gateway can read it
  header('Content-type: text/plain');
  echo $response;
} else {
  // You can then store this information in the database for your records
  $durationInSeconds  = $_POST['durationInSeconds'];
  $currencyCode  = $_POST['currencyCode'];
  $amount  = $_POST['amount'];
}
?>