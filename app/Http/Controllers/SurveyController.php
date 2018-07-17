<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Group;
use App\Models\Outbox;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSurvey;
use App\Models\Response;
use PDF;
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
        $group = Group::all()->where('user_id',\Auth::user()->id);
        $survey = new Survey;
        return view('surveys.create', compact('survey', 'group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurvey $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
       $read_question = Question::where('survey_id', $survey->id)->get();
        return view('surveys.show', compact('survey','read_question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $survey
     * @return \Illuminate\Http\Response
     */
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

     public function load_questionier($survey_id)
    {
       $survey=Survey::find($survey_id);
       return view('surveys.create_questions')->with(compact('survey')); 
    }
    public function template($survey_id){
       $template = Question::where('survey_id', $survey_id)->get();
       $survey=Survey::find($survey_id)->get();
    return view('surveys.template', compact('template','survey'));
    }
     
     
}
