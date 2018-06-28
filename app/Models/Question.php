<?php

namespace App\Models;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $fillable = [
		'description',
		'answer_type'
	];

    public function rules()
    {
    	return [
    		'description' => 'required|string',
    		'answer_type' => 'required|string',
    	];
    }

    public function storeAnswers($answers, $question_id)
    {
    	foreach (explode(',', $answers) as $answer) {
    		$response = new Response;
    		$response->answer = $answer;
    		$response->question_id = $question_id;
    		$response->save();
    	}
    }

    public function responses()
    {
    	return $this->hasMany(Response::class);
	}
	
	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}

    public function inboxes()
    {
        return $this->hasMany(Inbox::class);
    }
}
