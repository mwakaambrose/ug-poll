@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of Categories</div>

                <a href="{{route('category.create')}}">Add Category</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <th>Name</th> <th>Action</th>

                         @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td><a href="{{route('category.edit',$category->id)}}">Add Message</a> 
                             <a href="{{route('category.show',$category->id)}}">View Message</a>

           
 
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
