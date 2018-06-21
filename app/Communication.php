<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\includes\AfricasTalkingGateway;
use App\Outbox;

class Communication extends Model
{
    //

    public function send_SMS($phone_number,$sms,$question_id,$respondent_id)
     {
        $gateway = new AfricasTalkingGateway(env("API_USERNAME"),env("API_KEY"),"sandbox");
    	try {

            if (Outbox::all()->where('question_id',$question_id)->where('respondent_id',$respondent_id)->count()==0) {
              
    		$results = $gateway->sendMessage($phone_number,$sms,env("SHORT_CODE"),1);
    			foreach ($results as $key => $value) { 
    				$save_Outbox=new Outbox();
    				$save_Outbox->question_id=$question_id;  			
    				$save_Outbox->respondent_id=$respondent_id;
    				$save_Outbox->phone_number=$phone_number;
    				$save_Outbox->status=$value->status;
    				$save_Outbox->cost=$value->cost;
    				try {
    					$save_Outbox->save();
    				} catch (\Exception $e) {
    					echo $e->getMessage();
    				}
    			}
    		}
           
    	} catch (AfricasTalkingGatewayException $e) {
    		
    	}    	 
    }

    public function fetch_SMS()
    {
         $gateway = new AfricasTalkingGateway(env("API_USERNAME"),env("API_KEY"),"sandbox");
         try {
            $lastReceivedId = 0;
            $results = $gateway->fetchMessages($lastReceivedId);

            return $results;
               
         } catch (AfricasTalkingGatewayException $e) {
             
         }
    }
}
