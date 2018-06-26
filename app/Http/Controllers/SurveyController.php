<?php

namespace App\Http\Controllers;

use Auth;

use App\Models\Group;
use App\Models\Outbox;
use App\Models\Survey;
use App\Models\Question;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSurvey;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        $group = Group::all();
        $survey = new Survey;
 
        return view('surveys.create', compact('survey', 'group'));
 
    }
 
    public function store(StoreSurvey $request)
    {
        $this->validate($request,["name"=>"required","description"=>"required","group_id"=>"required"]);
        $survey = new Survey($request->all()); 
        $survey->group_id = $request->group_id;
        $survey->user_id = Auth::user()->id;
        if(!$survey->save()){
            flash('Something went wrong. Failed to create survey, Please try again.')->error();
            return back();           

        }
        flash('Survey created successfully')->success();
        return redirect("/surveys/{$survey->id}");
 
    }
 
    public function show(Survey $survey)
    {
        $read_question = Question::where('survey_id', $survey->id)->get();
        return view('surveys.show', compact('survey','read_question'));
     }
 
    public function edit(Survey $survey)
    { 
        $my_out_box=Outbox::select('phone_number', 
            'status', 
            'cost', 
            'questions.description', 
            'questions.created_at'
            )->join('questions','outboxes.question_id','questions.id')
             ->join('surveys','questions.survey_id','surveys.id')
             ->where('surveys.id', $survey->id)
             ->get();
        return view('surveys.outbox')->with(compact('my_out_box','survey'));      
    }

 
    public function update(StoreSurvey $request, Survey $survey)
    {
        //
    }

 
    public function destroy(Survey $survey)
    {
        //
    }

    public function load_questionier($survey_id)
    {
       $survey=Survey::find($survey_id);
       return view('surveys.create_questions')->with(compact('survey')); 
    }
}
