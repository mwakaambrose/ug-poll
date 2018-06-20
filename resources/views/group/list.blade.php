@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of groups</div>

                <a href="{{route('group.create')}}">Add group</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <th>Name</th><th>Actions</th>

                         @foreach($groups as $group)
                         <tr>
                             <td><a href="{{route('group.show',$group->id)}}">{{$group->name}}</a></td>
                             
                             <td>
                                 <!-- <a href="{{route('group.edit',$group->id)}}">Add Members</a> -->
                                 <!-- <a href="{{route('group.show',$group->id)}}">View Members</a> -->
                             </td>
                         </tr>
                          
                        @endforeach
                    </table>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection