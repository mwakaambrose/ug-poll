<?php
namespace App\includes;

class Voice{

   protected $sessionId = $_POST['sessionId'];
   protected $isActive  = $_POST['isActive'];
   
    //$currentCallState = 'None'; // for testing purposes
    public function voiceFunction($sessionID,$isActive,$question,$currentCallState="None"){

      if ($isActive == 1)  {
        if ($currentCallState == 'None') {
          $response  = '<?xml version="1.0" encoding="UTF-8"?>';
          $response .= '<Response voice="man" timeOut="60">';
          $response .= '<GetDigits finishOnKey="#">';
          $response .= '<Say>'.$question.'</Say>'; //speak questions to respondent
          $response .= '</GetDigits>';
          $response .= '</Response>';
          extract($_POST);
          // Read the dtmf digits [user Inputs]
          $userInput = $_POST['dtmfDigits'];
          if(isset($userInput)) {
          /**
            -store answer into database [answering format is the same as SMS =>qtnNumber Answer]
          */

          // Say Result to Respondent
          $response  = '<?xml version="1.0" encoding="UTF-8"?>';
          $response .= '<Response voice = "man">';
          $response .= '<Say>Thank you for </Say>';///At end send congguratory message to user for taking the survey
          $response .= '</Response>'; 


          }//end if[accountNumber]   
        }//end if [currentState]
        $currentCallState = 'Done';

        $this->saveCurrentCallState($sessionID, $currentCallState); // Implement this locally!

        header('Content-type: text/plain');
      }else {

        $callerNumber = $_POST['callerNumber'];
        $duration     = $_POST['durationInSeconds'];
        $currencyCode = $_POST['currencyCode'];
        $amount       = $_POST['amount'];
        //record error problem in DB
      }
      }//end function 
    public function saveCurrentCallState($sessionId, $currentCallState){
      
    }
}