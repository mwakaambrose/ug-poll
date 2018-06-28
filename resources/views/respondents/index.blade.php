@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Respondents</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <a href="/respondents/create" class="btn btn-success">+ Add New Respondent</a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped" id="data_table">
                    <thead>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Groups</th>
                     </thead>

                    <tbody>
                    @foreach($respondents as $respondent)
                        <tr>
                            <td>{{ $respondent->name }}</td>
                            <td>{{ $respondent->phone_number }}</td>
                            <td>{{ $respondent->address }}</td>
                            <td>{{ $respondent->gender }}</td>
                            <td>{{ $respondent->email_address }}</td>
                            <td>{{ isset($respondent->district) ? $respondent->district->name : '' }}</td>
                            <td>
                                @foreach($respondent->groups as $group)
                                    <a href="/groups/{{ $group->id }}">{{ $group->name }}</a>
                                @endforeach
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
