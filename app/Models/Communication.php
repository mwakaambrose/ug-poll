<?php

namespace App\Models;

use App\Models\Outbox;
use Illuminate\Database\Eloquent\Model;
use App\includes\AfricasTalkingGateway;

class Communication extends Model
{
    public function send_SMS($phone_number, $sms, $question_id, $respondent_id)
    {

		$gateway = new AfricasTalkingGateway(env("API_USERNAME"), env("API_KEY"), "agripoll");
		$respondent_outbox = Outbox::all()->where('question_id',$question_id)->where('respondent_id', $respondent_id);

    	try {

            if ($respondent_outbox->count() == 0) {
              
    			$results = $gateway->sendMessage(trim($phone_number), $sms, env("SHORT_CODE"), 1);
				
				foreach ($results as $key => $value) { 
    				$save_outbox = new Outbox();
    				$save_outbox->question_id = $question_id;  			
    				$save_outbox->respondent_id = $respondent_id;
    				$save_outbox->phone_number = $value->number;
    				$save_outbox->status = $value->status;
    				$save_outbox->cost = $value->cost;
    				try {
    					$save_outbox->save();
    				} catch (\Exception $e) {
    					echo $e->getMessage();
    				}
    			}
    		}
           
    	} catch (AfricasTalkingGatewayException $e) {}    	 
    }

 
    public function plain_SMS($phone_number, $sms)
    {
        $gateway = new AfricasTalkingGateway(env("API_USERNAME"), env("API_KEY"), "agripoll");
        try {

           $gateway->sendMessage(trim($phone_number), $sms, env("SHORT_CODE"), 1);             
                     
        } catch (AfricasTalkingGatewayException $e) {}  

    }

    public function fetch_SMS()
    {
        $gateway = new AfricasTalkingGateway(env("API_USERNAME"),env("API_KEY"),"agripoll");
        try {
            $lastReceivedId = 81898674;
            $results = array_reverse($gateway->fetchMessages($lastReceivedId));
            
            return  $results;
        } catch (AfricasTalkingGatewayException $e) {}
    }
}
