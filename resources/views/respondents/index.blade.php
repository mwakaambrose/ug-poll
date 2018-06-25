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
                <table class="table table-condensed table-striped" style="overflow: auto;">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Groups</th>
                    </tr>

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
                </table>
            </div>
        </div>
    </div>
@endsection
