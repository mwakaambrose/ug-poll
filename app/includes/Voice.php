<?php
namespace App\includes;
use App\Survey;
use App\Inbox;
use App\Reward;
use App\Communication;

class Voice{ 
    
    //$currentCallState = 'None'; // for testing purposes
    public function voice_function(){

      $send_sms = new Communication();
 
      if ($_POST['isActive'] == 1)  {

        $currentCallState = 'None';
        
        //read the first qn in this survey
        $survey = Survey::all()->last();
        $all_question = $survey->questions()->get();

        start_survey:

        foreach ($all_question as $question_value) {
          if ($currentCallState == 'None') {           
            $options = '';
            foreach ($question_value->responses as $response) {
                $options .= $response->answer.", or, ";
            }
          
            $question  =  $question_value->description ."Answer options are, {$options}";
            $response  = '<?xml version="1.0" encoding="UTF-8"?>';
            $response .= '<Response voice="man" timeOut="60">';
            $response .= '<GetDigits finishOnKey="#">';
            $response .= '<Say>'.$question.'</Say>';
            $response .= '</GetDigits>';
            $response .= '</Response>';
            header('Content-type: text/plain');
            
            echo $response;
            // extract($_POST);         
            $currentCallState = 'PromptSent'

            $answer = $_POST['dtmfDigits'];

            $outbox_id = NULL;

            if(isset($answer)) {                
              $this->store_user_response($answer,$_POST['callerNumber'],$outbox_id,$question_value->id);
            }
            else{
              $currentCallState = 'None';
              goto start_survey;//if user does not answer, repaet the survey

            }
           } 
          $currentCallState = 'None';           
        } 
      }

      $response  = '<?xml version="1.0" encoding="UTF-8"?>';
      $response .= '<Response voice="man" timeOut="60">';            
      $response .= '<Say>Thank you for conduting this survey with us.</Say>';           
      $response .= '</Response>';
      header('Content-type: text/plain');      
      echo $response;

      $recipients = array(array("phoneNumber" => $_POST['callerNumber'], "amount" => "UGX 100"));

      $send_sms->plain_SMS($_POST['callerNumber'], "Thank you for conducting a survey with us"); 
      $recipientStringFormat = json_encode($recipients);
      $gateway = new AfricasTalkingGateway(env("API_USERNAME"), env("API_KEY"));
      $results = $gateway->sendAirtime($recipientStringFormat);
      foreach($results as $result) {
          $save_reward = new Reward();
          $save_reward->phone_number = $result->phoneNumber;
          $save_reward->survey_id = $survey->id;
          $save_reward->amount = $result->amount;
          $save_reward->error_message = $result->errorMessage;
          $save_reward->requestId = $result->requestId;
          $save_reward->save();                                      
      }
      $currentCallState = 'Done';
    }    
  
    public store_user_response($answer,$phone_number,$outbox_id,$question_id)
    {
        $save_inbox = new Inbox();
        $save_inbox->answer = ucwords(strtolower($answer));
        $save_inbox->phone_number = $phone_number;
        $save_inbox->outbox_id = $outbox_id;
        $save_inbox->question_id = $question_id;                    
        $save_inbox->save(); 
    }
}