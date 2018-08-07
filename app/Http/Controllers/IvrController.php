<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\Group;
use App\Models\Survey;
use App\includes\AfricasTalkingGateway;
use App\includes\Voice;

class IvrController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $survey = Survey::find($request->survey_id);      
        $group = Group::find($survey->group_id); 
        foreach ($group->respondents as $respondent_value) {
            $phone = $respondent_value->phone_number;

             if ($phone[0] == "+") {
                $phone_number = $phone;
            } else if ($phone[0] == "0") {
                $out = ltrim($phone, "0");
                $phone_number = "+256".$out;
            } else {
                $phone_number=$phone;
            }
            $this->call_respondent($phone_number, $survey);            
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

    public function call_respondent($phone_number, $survey)
    {
      $gateway = new AfricasTalkingGateway(env("API_USERNAME"), env("API_KEY"));
      try 
        {
          // Make the call
          $results = $gateway->call(env("PHONE_NUMBER"), $phone_number);
          //This will loop through all the numbers you requested to be called
          $response  = '<?xml version="1.0" encoding="UTF-8"?>';
          $response .= '<Response>';
          $response .= '<Say>Welcome to our survey</Say>';
          $response .= '</Response>';
          // Print the response onto the page so that our gateway can read it
          header('Content-type: text/plain');
          echo $response;
          foreach($results as $result) {
            //Only status "Queued" means the call was successfully placed
            echo $result->status;
            echo $result->phoneNumber;
            echo "<br/>";
          }
                
        }
        catch ( AfricasTalkingGatewayException $e )
        {
          echo "Encountered an error while making the call: ".$e->getMessage();
        }
    }

    public function call_back_path()
    {
        $ivr_object = new Voice();
        $ivr_object->voice_function();
    }
}
