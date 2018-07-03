@extends('layouts.app')

@section('content')

    @include('shared._heading', [
        'heading' => 'New SMS Actions',
        'should_show_action' => false,
        'action_url' => '/sms-actions/create',
        'action_name' => 'New SMS action'
    ])

    <div class="card">
        <div class="card-body">
            <form method="POST" action="/sms-actions">
                @csrf

                <div class="form-group">
                    <div class="col">
                        <label>Choose a survey</label>
                        <select name="survey_id" class="form-control">
                            <option></option>
                            @foreach($survey as $surveys)
                              <option value="{{$surveys->id}}">{{$surveys->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <label>Minimum Weight</label>
                        <input type="number" step="any" name="minimum_weight" class="form-control">
                    </div>
                    <div class="col">
                        <label>Maximum Weight</label>
                        <input type="number" step="any" name="maximum_weight" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <label>SMS Action</label>
                        <textarea name="sms_action" cols="30" rows="5" class="form-control" placeholder="Provide the sms that will be sent to the respondents when their answers falls between the answer weights."></textarea>
                    </div>
                </div>
                <div class="col">
                    <button class="btn btn-success" type="submit">
                        Save action <span class="badge badge-primary"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection