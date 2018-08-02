<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Group;
use App\Models\SMS;
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
        $surveys = Survey::orderBy('id','DESC')->get();
        // dd($surveys->toJson());
        $data = [];
        foreach($surveys as $survey){
            $result   = [];

            $result[]   = $survey->id;
            
            $result[] = '<a data-fancybox data-options=\'{ "caption" : "Survey Name: '.$survey->name.'", "src" : "'.url("/surveys", $survey->id).'", "type" : "iframe" }\' href="javascript:;">'.$survey->name.'</a>';

            $result[] = '<a class="btn btn-secondary btn-info" data-fancybox data-options=\'{ "caption" : "Add Question to Survey: '.$survey->name.'", "src" : "'.url("/load_questionier", $survey->id).'", "type" : "iframe" }\' href="javascript:;">Add</a>';

            $result[] = $survey->questions()->count();
         
            $result[] = '<a class="btn btn-secondary btn-info" data-fancybox data-options=\'{ "caption" : "Outbox for Survey: '.$survey->name.'", "src" : "'.url("/surveys", [$survey->id,'edit']).'", "type" : "iframe" }\' href="javascript:;">Outbox</a>';

            $result[] = $survey->groups->name;        
                       
            $result[] = $survey->send_time;        
            
            $result[] = "<p style='overflow-wrap: break-word;'>".$survey->description."</p>";

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

    public function reuse_survey(Request $request)
    {
        $this_survey = Survey::find($request->survey_id);
        // instatiate for new Survey record
        $newsurvey = new Survey();
        $newsurvey->user_id = \Auth::user()->id;
        $newsurvey->group_id = $request->group_id;
        $newsurvey->name = $this_survey->name;
        $newsurvey->is_completed = $this_survey->is_completed;
        $newsurvey->description = $this_survey->description;
        $newsurvey->send_time = $this_survey->send_time;
        try {
            $newsurvey->save();

            // return json_encode($this_survey->questions);

            foreach ($this_survey->questions as $questions_value) {

                $save_question = new Question();
                // replicate every qn for this new survey
                $save_question->survey_id = $newsurvey->id;
                $save_question->description = $questions_value->description;
                $save_question->answer_type = $questions_value->answer_type;
                $save_question->save();
                // replicate the responses as well
                foreach ($questions_value->responses as $response_value) {
                    $new_response = new Response();
                    $new_response->question_id = $save_question->id;
                    $new_response->answer = $response_value->answer;
                    $new_response->value = $response_value->value;
                    $new_response->save();                   
                }
            }     
           

           // replicate its call to action
            foreach ($this_survey->sms as $sms_value) {
                $new_sms = new SMS();
                $new_sms->minimum_weight = $sms_value->minimum_weight;
                $new_sms->maximum_weight = $sms_value->maximum_weight;
                $new_sms->survey_id = $newsurvey->id;
                $new_sms->category_id = $sms_value->category_id;
                $new_sms->save();              
            }
            echo "Saved";
        } catch (\Exception $e) {
            echo $e->getMessage();
            return;
        }
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

    public function survey_sender()
    {
        $surveys = Survey::orderBy('id','DESC')->get();
        return view("surveys.send_survey")->with(['surveys'=>$surveys]);
    }
     
     
}
