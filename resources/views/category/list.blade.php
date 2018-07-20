@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                 
                <div class="card-body">
                    <h3>List of Categories
<span class="fa fa-question-circle"     title='List Of Categories&#013;&#013;
This Page Displays the List of Registered categories that contain SMS templates that can be resent to Respondents.
After they complete the survey
&#013;
-To Add a New Category of Messages Template Click the Add Category Button&#013;
-You Add a new SMS message by clicking the Add Message Button&#013;
-You To View all the Saved Messages click the View Message Button &#013;
-To Delete The Saved Messages,click the Delete Button&#013;
'></span>
                    </h3>

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
                            <td>
                               
                            <form style="float: right;" action="/category/{{ $category->id }}" method="POST">
                                {{method_field('DELETE')}}
                                {{ csrf_field() }}
                                <a class="btn btn-success" href="{{route('category.edit',$category->id)}}">Add Message</a> 
                                <a class=" btn btn-info" href="{{route('category.show',$category->id)}}">View Message</a> 
                                <span class="glyphicon glyphicon-trash"></span>
                                <input type="submit" class="btn btn-danger" value="Delete "/>
                            </form>         
 
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
