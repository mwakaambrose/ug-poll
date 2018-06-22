<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Communication;
use App\Survey;
use App\Group;
use App\Outbox;
use App\Inbox;
use App\Reward;
use App\Question;
use App\includes\AfricasTalkingGateway;

class OutboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $send_SMS=new Communication();

        foreach ($send_SMS->fetch_SMS() as $inbox_content) {

            $check_in_outbox=Outbox::all()->where('phone_number',$inbox_content->from)->last();

            echo json_encode($check_in_outbox);
           
            if (json_encode($check_in_outbox) != "null") {
               
                if (Inbox::all()->where('outbox_id',$check_in_outbox->id)->count()==0) {
                  
                    $save_inbox=new Inbox();
                    $save_inbox->answer=$inbox_content->text;
                    $save_inbox->phone_number=$inbox_content->from;
                    $save_inbox->outbox_id=$check_in_outbox->id;
                    $save_inbox->save();
                }

                else{
                    #send next question
                    $survey=$check_in_outbox->questions->survey;

                    $previous_qn_id=Question::where('survey_id',$survey->id)->where('id','<',$check_in_outbox->question_id)->max('id');

                    $next_qn_id=Question::where('survey_id',$survey->id)->where('id','>',$check_in_outbox->question_id)->min('id');

                    // echo "Preve ID: ".$previous_qn_id." Current: ".$check_in_outbox->question_id." Next: ".$next_qn_id;                   

                    if (empty($next_qn_id)) {
                        # No more question, send the Airtime
                        // echo "No more qns";
                        if (Reward::all()->where('phone_number',$inbox_content->from)->where('survey_id',$survey->id)->count()==0) {

                            $recipients = array(array("phoneNumber"=>$inbox_content->from, "amount"=>"UGX 100"),);

                            $recipientStringFormat = json_encode($recipients);
                            $gateway = new AfricasTalkingGateway(env("API_USERNAME"),env("API_KEY"));
                            $results = $gateway->sendAirtime($recipientStringFormat);
                                   foreach($results as $result) {
                                        $save_reward=new Reward();
                                        $save_reward->phone_number = $result->phoneNumber;
                                        $save_reward->survey_id = $survey->id;
                                        $save_reward->amount = $result->amount;
                                        $save_reward->error_message = $result->errorMessage;
                                        $save_reward->requestId = $result->requestId;
                                        $save_reward->save();                                      
                                    }
                                }
                            }

                    elseif (!empty($next_qn_id)) {                       

                        if (Inbox::all()->where('outbox_id',$check_in_outbox->id)->count()==1) {
                            $next_question=Question::find($next_qn_id);

                            $sms = $next_question->description." [".str_replace(',', ' OR ',$next_question->posible_answers)."]";

                            $send_SMS->send_SMS($inbox_content->from,$sms,$next_question->id,$check_in_outbox->respondent_id); 
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
        $survey=Survey::find($request->survey_id);
        $first_qn=$survey->questions()->first(); 
        $group=Group::find($survey->group_id);
        foreach ($group->respondent as $respondent_value) {
            $phone_number=$respondent_value->phone_number;
            $questions=$first_qn->description." [".str_replace(",", " OR ", $first_qn->posible_answers."]");

            $send_SMS=new Communication();
            $send_SMS->send_SMS($phone_number,$questions,$first_qn->id,$respondent_value->id);
          
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
        //
        $question=Question::find($id);

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
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
