<?php

namespace App\Http\Controllers;

use Auth;
use App\Survey;
use App\Outbox;
use App\Group;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSurvey;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $survey = new Survey;
        $group=Group::all();
        return view('surveys.create', compact('survey','group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurvey $request)
    {
        $this->validate($request,["name"=>"required","description"=>"required","group_id"=>"required"]);
        $survey = new Survey($request->all());
        $survey->group_id=$request->group_id;
        $survey->user_id = Auth::user()->id;
        try {
            $survey->save();
            flash('Survey created successfully')->success();
            return redirect("/surveys/{$survey->id}");
            
        } catch (\Exception $e) {
            flash('Something went wrong')->error();
            return back();           
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        // dd($survey);
        $read_Question=Question::all()->where('survey_id',$survey->id);


        return view('surveys.show', compact('survey','read_Question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        // dd($survey);
        // read for me outboxes of questions that belong to this survey
        // $read_outboxes=Survey::find($survey->id)->questions()->get();
      
        $my_out_box=Outbox::select('phone_number','status','cost','questions.description','questions.created_at')->join('questions','outboxes.question_id','questions.id')->join('surveys','questions.survey_id','surveys.id')->where('surveys.id',$survey->id)->get();

        return view('surveys.outbox')->with(compact('my_out_box','survey'));      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSurvey $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
