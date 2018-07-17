<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Inbox;
use App\Models\Group;
use App\Models\Survey;
use App\Models\Outbox;
use App\Models\Reward;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request; 
use App\Models\Communication;
use App\Models\CategoryMessage;
use App\includes\AfricasTalkingGateway;

class OutboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $send_sms = new Communication();

        foreach ($send_sms->fetch_SMS() as $inbox_content) {            

            // 34 YES  [expected response format  34 is the question id]

            $response = explode(" ", $inbox_content->text);           
            
            $check_in_outbox = Outbox::all()->where('phone_number', $inbox_content->from)->where('question_id',$response[0])->last();          

            if (isset($check_in_outbox)) {

                $count=Inbox::all()->where('phone_number', $inbox_content->from)->where('outbox_id',$check_in_outbox->id)->where('question_id',$response[0])->count();
                
                if ($count == 0) {
                    try {
                        
                        $save_inbox = new Inbox();
                        $save_inbox->answer = ucwords($response[1]);
                        $save_inbox->phone_number = $inbox_content->from;
                        $save_inbox->outbox_id = $check_in_outbox->id;
                        $save_inbox->question_id = $response[0];                    
                        $save_inbox->save();  
                    } catch (\Exception $e) {
                        
                    }
                    
                } else {
                    #send next question
                    $survey = $check_in_outbox->questions->survey;
                    $previous_question_id = Question::where('survey_id', $survey->id)->where('id', '<', $check_in_outbox->question_id)->max('id');
                    $next_question_id = Question::where('survey_id', $survey->id)->where('id', '>', $check_in_outbox->question_id)->min('id');

                     if (empty($next_question_id)) {                       
                        // No more question, send the Airtime and Call to action
                        // Send them ssm to thank them for paticipating
                        // and ask them to paticipate more.

                        if (Reward::all()->where('phone_number', $inbox_content->from)->where('survey_id', $survey->id)->count() == 0) {
                             // call to action
                            $survey_qns = Question::select('id')->where('survey_id',$survey->id)->get();
                            $sum_of_values=0;
                            foreach ($survey_qns as $survey_value) {
                                //read the Inbox for each qn on this respondent
                                $respondent_inbox = Inbox::select('phone_number','answer')->where('question_id',$survey_value->id)->where('phone_number',$inbox_content->from)->first();
                                // read the coresponding letter for that answer
                                $posible_response = Response::all()->where('question_id',$survey_value->id)->where('answer',$respondent_inbox->answer)->last();

                                if (!empty($posible_response)) {
                                    $sum_of_values = $sum_of_values + $posible_response->value;                  
                                }
                            }

                            // read the call action that siuts the $sum_of_values
                            $posible_action = SMS::all()->where('minimum_weight','<=',$sum_of_values)->where('maximum_weight','>=',$sum_of_values)->where('survey_id',$survey_value->id)->last();                           

                            if (json_encode($posible_action)!="null") {
                                // read messages in the target category
                                $raed_messages = CategoryMessage::select('description')->where('category_id',$posible_action->category_id)->get();                                                             
                                foreach ($raed_messages as $message_value) {
                                   $send_sms->plain_SMS($inbox_content->from,$message_value->description); //this is the SMS call to action to the respondent
                                }                                
                            }
                            // Airtime

                            $recipients = array(array("phoneNumber" => $inbox_content->from, "amount" => "UGX 100"));

                            $send_sms->plain_SMS($inbox_content->from, "Thank you for conducting a survey with us"); 
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
                        }
                    } else if (!empty($next_question_id)) {  
                        $options = '';
                        // echo $response[0];
                        $inbox = Inbox::where('outbox_id', $check_in_outbox->id)
                            ->where('question_id', $response[0])
                            ->where('phone_number', $check_in_outbox->phone_number)
                            ->get();                         
                        
                        if ($inbox->count() > 0) {
                            $next_question = Question::find($next_question_id);
                            foreach ($next_question->responses as $response) {
                                $options .= "\n- ".$response->answer;
                            }
                            $questions = $next_question->description ."{$options} \n  Code: ".$next_question->id;
                            $send_sms->send_SMS($inbox_content->from, $questions, $next_question->id, $check_in_outbox->respondent_id); 
                        }  
                    }                
                }
            } 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //read the first qn in this survey
        $survey = Survey::find($request->survey_id);
        $first_question = $survey->questions()->first(); 
        $group = Group::find($survey->group_id);
        $options = '';

        foreach ($first_question->responses as $response) {
            $options .= "\n- ".$response->answer;
        }

        foreach ($group->respondents as $respondent_value) {
            $phone_number = $respondent_value->phone_number;            
            $questions = $first_question->description ."{$options} \n  Code: ".$first_question->id;
            $send_sms = new Communication();
            $send_sms->send_SMS($phone_number, $questions, $first_question->id, $respondent_value->id); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        foreach ($question->outbox as $value) {
            echo $value->inbox;
        }
        // return view('surveys.answers', compact('read_responses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {}
}
