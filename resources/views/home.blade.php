@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">You have {{ $surveys->count() }} survey(s).</div>

                <div class="card-body">

                    @if($surveys->count() === 0)
                        You don't have any surveys yet. <a href="/surveys/create">+ Create one now</a>
                    @else
                        <table class="table table-condensed table-striped">
                            <tr>
                                <th>Survey Title</th>
                                <th>Sceduled Date</th>
                                <th></th>
                            </tr>

                            @foreach($surveys as $survey)
                                <tr>
                                    <td>{{ $survey->name }}</td>
                                    <td>{{ $survey->send_time }}</td>
                                    <td>
                                        <a href="/surveys/{{ $survey->id }}">View Reports</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
