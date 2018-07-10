@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>Respondents in {{ $group->name }}</h4>
        </div>
    </div>

    <div class="col-sm-12">    
       <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped" id="data_table">
                    <thead>
                        <th>Name</th>
                        <th>Telephone Number</th>
                        <th class="text-center">Actions</th>
                    </thead>
                    <tbody>               
                   
                      @foreach($group->respondents as $repondent)
                         <tr>
                             <td>{{ $repondent->name }}</td>
                             <td>{{ $repondent->phone_number }}</td>
                             <td class="text-center">
                                 <a href="/respondents/{{ $repondent->id }}" class="text-success mx-3">Edit</a>
                             </td>
                         </tr>
                    @endforeach 
                </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@include('shared._datatable_scripts')
