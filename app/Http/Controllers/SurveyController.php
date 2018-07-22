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
use App\Http\Requests\StoreSurveyForm;
use App\Models\Response;

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
        $surveys = Survey::all()->where('user_id',\Auth::user()->id);
        $group = Group::all()->where('user_id',\Auth::user()->id);
        return view('surveys.index', compact('surveys','group'));
    }

    public function fetchSurveys()
    {
        $surveys = Survey::all();
        // dd($surveys->toJson());
        $data = [];
        foreach($surveys as $survey){
            $result   = [];
            
            $result[] = '<a data-fancybox data-options=\'{ "caption" : "Survey Name: '.$survey->name.'", "src" : "'.url("/surveys", $survey->id).'", "type" : "iframe" }\' href="javascript:;">'.$survey->name.'</a>';
            $result[] = $survey->description;
            $result[] = $survey->send_time;
            $result[] = '<a class="btn btn-secondary btn-info" data-fancybox data-options=\'{ "caption" : "Add Question to Survey: '.$survey->name.'", "src" : "'.url("/load_questionier", $survey->id).'", "type" : "iframe" }\' href="javascript:;">Add</a>';
            $result[] = '<a class="btn btn-secondary btn-info" id="process_survey" href="#">Send</a>';
            $result[] = '<a class="btn btn-secondary btn-info" data-fancybox data-options=\'{ "caption" : "Outbox for Survey: '.$survey->name.'", "src" : "'.url("/surveys", [$survey->id,'edit']).'", "type" : "iframe" }\' href="javascript:;">Outbox</a>';
            $result[] = $survey->questions()->count();

            $data[]   = $result;
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
    public function store(StoreSurveyForm $form)
    {
        return $form->persist();
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
