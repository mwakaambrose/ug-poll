@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>{{ $group->name }}</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <form action="/groups/{{ $group->id }}" method="POST">
                {{method_field('DELETE')}}
                {{ csrf_field() }}
                <span class="glyphicon glyphicon-trash"></span>
                <input type="submit" class="btn btn-danger" value="Delete Group"/>
            </form>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row py-3">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $group->respondents->count() }}</h5>
                        <p class="card-text">Respondents</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">0</h5>
                        <p class="card-text">Surveys</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Surveys</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>Title</th>
                        <th>Participants</th>
                        <th class="text-center">Actions</th>
                    </tr>

                    {{-- Remove this one feature is built --}}
                    <tr>
                         <td><a href="#">Fake Survey</a></td>
                         <td>3</td>
                         <td class="text-center">
                             <a href="#" class="text-success mx-3">View Statistics</a>
                         </td>
                     </tr>

                    {{-- waiting feature --}}
                     {{-- @foreach($group->surveys as $survey)
                         <tr>
                             <td><a href="/survey/{{ $survey->id }}">{{ $survey->name }}</a></td>
                             <td>{{ $survey->respondents_count }}</td>
                             <td class="text-center">
                                 <a href="/surveys/{{ $survey->id }}" class="text-success mx-3">View Statistics</a>
                             </td>
                         </tr>
                    @endforeach --}}
                </table>
            </div>
        </div>
    </div>

@endsection
