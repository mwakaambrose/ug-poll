@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>{{ $group->name }}</h4>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card my-3">
            <div class="card-body">
                <form action="/respondents/import" method="POST">
                    <div class="form-group">
                        <label for="file"></label>
                        {{-- <input type="multipart" name="file"> --}}
                    </div>
                </form>
            </div>
        </div>

        <h4>Respondents</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Telephone Number</th>
                        <th class="text-center">Actions</th>
                    </tr>

                    {{-- Remove this one feature is built --}}
                    <tr>
                         <td><a href="#">Fake Person</a></td>
                         <td>+256752014071</td>
                         <td class="text-center">
                             <a href="#" class="text-success mx-3">Remove</a>
                         </td>
                     </tr>

                    {{-- waiting feature --}}
                     {{-- @foreach($group->respondents as $repondent)
                         <tr>
                             <td><a href="/repondent/{{ $repondent->id }}">{{ $repondent->name }}</a></td>
                             <td>{{ $repondent->respondents_count }}</td>
                             <td class="text-center">
                                 <a href="/repondents/{{ $repondent->id }}" class="text-success mx-3">Remove</a>
                             </td>
                         </tr>
                    @endforeach --}}
                </table>
            </div>
        </div>
    </div>

@endsection
