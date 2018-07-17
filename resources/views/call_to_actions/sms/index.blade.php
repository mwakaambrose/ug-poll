@extends('layouts.app')

@section('content')
    @include('shared._heading', [
        'heading' => 'SMS Actions',
        'should_show_action' => true,
        'action_url' => '/sms-actions/create',
        'action_name' => 'New SMS action'
    ])
    <h4><span class="fa fa-question-circle"     title='SMS Actions&#013;&#013;
This Page Displays the Set Call to Action Responses after a Survey is conducted ,The Possible values are numerical values that are summed up and a range is set for particular responses received from the respondents and an appopriate Action is sent to the Respondent after he/She Receives the Airtime Reward
&#013;
-To set a new Call to SMS action click the New SMS action button&#013;
-You can Export the Call to Actions Records as CSV,Excel Sheet and PDF 
'></span><p /></h4>
    <div class="card mt-3">
        <div class="card-body">
            <table class="nowrap table table-bordered table-striped" id="data_table">
                <thead>
                    <th>#</th>
                    <th>Survey</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>SMS action category</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    @foreach($sms as $action)
                      @if(Auth::user()->id)
                        <tr>
                            <td>{{$action->id}}</td>
                            <td>{{$action->survey->name}}</td>
                            <td>{{$action->minimum_weight}}</td>
                            <td>{{$action->maximum_weight}}</td>
                            <td>{{$action->category->name}}</td>
                            <td>
                                <form method="POST" action="/sms-actions/{{$action->id}}">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endif                        
                        @endforeach 
                </tbody>


            </table>

           
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')