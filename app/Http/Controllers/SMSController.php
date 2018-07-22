<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSMS;
use App\Models\Survey;
use App\Models\Category;
use Auth;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = SMS::all();
        $survey = Survey::all()->where('user_id',Auth::user()->id);
        $category = Category::all();
        // return $sms->category->toArray();
        return view('call_to_actions.sms.index', compact('sms','survey','category'));
    }

    public function fetchSMSActions()
    {   
        $sms = SMS::all();
        
        $data = [];
        foreach($sms as $action){
            $result   = [];
            $result[] = $action->id;
            $result[] = $action->survey->name;
            $result[] = $action->minimum_weight;
            $result[] = $action->maximum_weight;
            $result[] = $action->category->name;

            $result[] = '<button id="delete" href="'.$action->id.'">DELETE</button>';

            $data[]   = $result;
            $x =  response()->json($data);
        }
        $x =  response()->json($data);

        return $x;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("call_to_actions.sms.create")->with(['survey'=>Survey::all()->where('user_id',Auth::user()->id),'category'=>Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSMS $form)
    {        
        return $form->persist();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function show(SMS $sMS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function edit(SMS $sMS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SMS $sMS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //    SMS::destroy($id);
        SMS::find($id)->delete();
        return response()->json(["success"=>"SMS Action successfully deleted."]);
    //    flash("SMS action deleted successfully")->success();
    //    return back();
    }
}
