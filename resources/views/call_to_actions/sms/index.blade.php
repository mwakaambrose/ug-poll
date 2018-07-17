@extends('layouts.app')

@section('content')
    @include('shared._heading', [
        'heading' => 'SMS Actions',
        'should_show_action' => true,
        'action_url' => '/sms-actions/create',
        'action_name' => 'New SMS action'
    ])

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