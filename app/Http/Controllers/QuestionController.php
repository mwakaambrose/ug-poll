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
    public function index()
    {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestion $request, Survey $survey)
    {
        $question = new Question($request->all());
        $question->survey_id = $survey->id;
        if (!$question->save()) {
            flash('Failed to add question')->error();
            return back();
        }
        if ($request->answer_type == 'objective_type') {
            if (count($request->answertext) == count($request->answervalue)) {
                $question->storeAnswers($request->answertext, $request->answervalue, $question->id);
                flash('Question added successfully')->success();
            }else{
                flash('Number of posible answers should be equal to the number of values')->error();
            }
        }        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestion $request, Question $question)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
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
