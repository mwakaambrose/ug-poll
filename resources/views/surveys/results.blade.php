@extends('layouts.app')

@section('content')
    @include('shared._heading', [
        'heading' => 'Survey Results',
        'should_show_action' => false,
        'action_url' => '',
        'action_name' => ''
    ])

    <div class="card mt-3">
        <div class="card-body">
            <h5>{{ $survey->name }}</h5>
            <p class="text-muted">{{$survey->description }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Survey Questions</h5>
            <hr>
            @if($survey->questions->count() == 0)
                <div class="alert alert-info">
                    <strong>No questions added.</strong> <a href="#" data-toggle="modal" data-target="#questions">Add</a>
                </div>
            @endif
            @foreach($survey->questions as $question)
                <h6>{{ $question->description }} <span class="text-muted small">
                        {{ $question->answer_type }}
                        <a href="/questions/{{$question->id}}/delete" class="text-danger">(Delete)</a>
                    </span>
                </h6>
                @foreach($question->responses as $response)
                    <li>{{ $response->answer }}</li>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Survey Answers from <a href="/groups/{{ $survey->group->id }}">{{ $survey->group->name }}</a></h5>
            <hr>
            <table class="table table-responsive table-striped table-condensed"
            style="font-size:14px;"
            >
                <tr>
                    <th>Respondent Name</th>
                    <th>Location</th>
                    <th>Gender</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                </tr>

                @foreach($survey->group->respondents as $respondent)
                    <tr>
                        <td>{{ $respondent->name }}</td>
                        <td>{{ $respondent->address }}</td>
                        <td>{{ $respondent->gender }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
