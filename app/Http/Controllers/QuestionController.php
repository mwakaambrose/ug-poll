<?php

namespace App\Http\Controllers;


use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestion;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){}

    public function create()
    {
         
    }
 
 
    public function store(StoreQuestion $request, Survey $survey)
    {
        $question = new Question($request->all());
        if ($request->answer_type == 'objective_type') {
            if (strlen($request->answers) == 0) {
                flash('You need to provide atleast one answer option')->error();
                return back();
            }
        }
        $question->survey_id = $survey->id;
        if (!$question->save()) {
            flash('Failed to add question')->error();
            return back();
        }
        if ($request->answer_type == 'objective_type') {
            if (strlen($request->answers) > 0) {
                $question->storeAnswers($request->answers, $question->id);
            }
        }
        flash('Question added')->success();
        return back();
 
    }
 
    public function show(Question $question){}
    public function edit(Question $question){}
    public function update(StoreQuestion $request, Question $question){}
 
   
    public function destroy(Question $question)
    {
        if (!$question->delete()) {
            flash('Failed to delete the question')->error();
            return back();
        }
        flash('Question and its answers deleted.')->error();
        return back(); 
    }
}