@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                 
                <div class="card-body">
                    <h3>List of Categories</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a class="btn btn-primary" style="float: right;" href="{{route('category.create')}}">Add Category</a>
                    <br><br>

                    <table class="table">
                        <th>Name</th> <th>Action</th>

                         @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td><a class="btn btn-success" href="{{route('category.edit',$category->id)}}">Add Message</a> 
                             <a class=" btn btn-info" href="{{route('category.show',$category->id)}}">View Message</a>          
 
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
