@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of Members</div>

                <a href="{{route('respondent.create')}}">Add members</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <th>Name</th> <th>Phone Number</th> <th>Address</th> <th>Gender</th> <th>Email</th> <th>District</th> <th>Groups</th>   <th>Actions</th>

                        @foreach($respondant as $respondants)
                            <tr>
                                <td>{{$respondants->name}}</td>
                                <td>{{$respondants->phone_number}}</td>
                                <td>{{$respondants->address}}</td>
                                <td>{{$respondants->gender}}</td>
                                <td>{{$respondants->email_address}}</td>
                                <td>{{$respondants->district->name}}</td>
                                <td>
                                    @foreach($respondants->group as $groups)
                                      {{$groups->name}}
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>                         
                        @endforeach
                    </table>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection