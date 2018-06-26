@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Groups</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <a href="/groups/create" class="btn btn-success">+ Add New Group</a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Respondents</th>
                        <th class="text-center">Actions</th>
                    </tr>

                     @foreach($groups as $group)
                         <tr>
                             <td><a href="/groups/{{ $group->id }}">{{ $group->name }}</a></td>
                             <td>{{ $group->respondents_count }}</td>
                             <td class="text-center">
                                 <a href="/groups/{{ $group->id }}/edit" class="text-info mx-3">Edit Members</a>
                                 <a href="/groups/{{ $group->id }}" class="text-success mx-3">View Details</a>
                             </td>
                         </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
