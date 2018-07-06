@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All SMS Templates in {{$category->name}}</div>

                <a href="{{route('category.edit',$category->id)}}">Add Message</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ol>
                        @foreach($category->categorymessage as $message)
                          <li>
                              {{$message->description}}

             <form action="/category_message/{{ $message->id }}" method="POST">
                {{method_field('DELETE')}}
                {{ csrf_field() }}
                <span class="glyphicon glyphicon-trash"></span>
                <input type="submit" class="btn btn-danger" value="Delete "/>
            </form>
                          </li>
                        @endforeach
                    </ol>

                              
                </div>
            </div>
        </div>
    </div>
</div>
@endsection