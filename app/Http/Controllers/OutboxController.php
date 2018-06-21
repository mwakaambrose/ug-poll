<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Communication;
use App\Survey;
use App\Group;
use App\Outbox;
use App\Inbox;
use App\Question;

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
        //
        $send_SMS=new Communication();
        $my_inbox=$send_SMS->fetch_SMS();
        foreach ($my_inbox as $inbox_value) {
            // get the person that sent this inbox phone Number
            $user_phonenumber=str_replace("+","", $inbox_value->from);
            //in the out box, what last record does this number corespond to.
            $outbox=Outbox::all()->where('phone_number',$user_phonenumber);//this means, that inbox is a response to that particular question
            foreach ($outbox as $out_box) {
             
            if (json_encode($out_box)!="null") {//if there exists a corresponding outbox
                #what was the question_Id, and from what survey is this question, such that we send the next question
                // return $out_box->questions;
                $the_survey=$out_box->questions->survey;//this is the survey from which this response corresponds

                try {
                    // save the response
                    $saveInbox=new Inbox();
                    $saveInbox->answer=$inbox_value->text;
                    $saveInbox->phone_number=$inbox_value->from;
                    $saveInbox->outbox_id=$out_box->id;
                    try {
                        if (Inbox::all()->where('outbox_id',$out_box->id)->where('phone_number',$inbox_value->from)->count()==0) {
                            # code...
                             $saveInbox->save();//this is where the analysis will come from
                        }
                        else{
                            // echo Inbox::all()->where('outbox_id',$out_box->id)->where('phone_number',$inbox_value->from);
                        }
                       
                    } catch (\Exception $e) {
                        
                    }

                    // try sending the next question 
                    try {
                        $send_SMS=new Communication();
                        $Questions=Question::find(Question::where('survey_id',$the_survey->id)->where('id','>',$out_box->question_id)->min('id'));

                        //WE NEED TO CHECK IF PREV QN WAS ANSWEREd

                        $prev_qn=Question::where('survey_id',$the_survey->id)->where('id','<',$out_box->question_id)->min('id');

                        echo $prev_qn;

                        if (Outbox::where('question_id',$prev_qn)->where('phone_number',$user_phonenumber)->last()!="null") {
                            // if user has recieved this qn, did he answer it?
                            $this_out_box=Outbox::where('question_id',$prev_qn)->where('phone_number',$user_phonenumber)->last();

                            if (Inbox::all()->where('outbox_id',$this_out_box->id)->where('phone_number',$inbox_value->from)->count()==1) {
                                // Have we recieved his answer?
                                $sms=$Questions->description."[".str_replace(',', ' OR ',$Questions->posible_answers)."]";
                                $send_SMS->send_SMS($user_phonenumber,$sms,$Questions->id,$out_box->respondent_id);  
                            }

                        }



                       
                    } catch (\Exception $e) {
                        // The code to send a reword is put here, this happens when No more questions
                    }                   
                    
                } catch (\Exception $e) {
                    // echo $e->getMessage();
                }
            }

            else{
                // echo "No record related to the inbox";
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
            $send_SMS->send_SMS($respondent_value->phone_number,$questions,$first_qn->id,$respondent_value->id);
          
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
